<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogComment\BlogCommentUpdateIsPublishedRequest;
use App\Http\Requests\Admin\BlogPost\BlogPostUpdateIsPublishedRequest;
use App\Models\BlogComment;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AdminApiController extends Controller
{
    /**
     * Returns array with status key as 1 if comment is published or 0 if unpublished,
     * published_at key as "d M H:i" formatted time or null if not published
     *
     * @param BlogCommentUpdateIsPublishedRequest $request
     * @param BlogComment $comment
     * @return array
     */
    public function togglePublishComment(
        BlogCommentUpdateIsPublishedRequest $request,
        BlogComment                         $comment
    ): array
    {
        $this->ajaxGuard($request);

        $comment->status = $request->input('status');
        $comment->tapPublishedAt();

        $comment->save();

        return [
            'status' => $comment->status,
            'published_at' => $comment->getPublishedAtShortened()
        ];
    }

    /**
     * Returns array with status key as 1 if post is published or 0 if unpublished
     * published_at key as "d M H:i" formatted time or null if not published
     *
     * @param BlogPostUpdateIsPublishedRequest $request
     * @param BlogPost $post
     * @return array
     */
    public function togglePublishPost(
        BlogPostUpdateIsPublishedRequest $request,
        BlogPost                         $post
    ): array
    {
        $this->ajaxGuard($request);

        $post->status = $request->input('status');
        $post->tapPublishedAt();

        $post->save();

        return [
            'status' => $post->status,
            'published_at' => $post->getPublishedAtShortened()
        ];
    }

    /**
     * @throws BadRequestException
     * @param Request $request
     * @return void
     */
    private function ajaxGuard(Request $request): void
    {
        if (! $request->ajax()) {
            throw new BadRequestException('You can only make ajax requests to this route');
        }
    }

}
