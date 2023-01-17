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
     * Returns BlogComment array with status key as 1 if comment is published or 0 if not
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

        if (
            $comment->isPublished() &&
            $comment->neverPublishedBefore()
        ) {
            $comment->publish();
        }

        $comment->save();

        return [
            'status' => $comment->status,
            'published_at' => $comment->getPublishedAtShortened()
        ];
    }

    /**
     * Returns BlogPost array with status key as 1 if post is published or 0 if not
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

        if (
            $post->isPublished() &&
            $post->neverPublishedBefore()
        ) {
            $post->publish();
        }

        $post->save();

        return [
            'status' => $post->status,
            'published_at' => $post->getPublishedAtShortened()
        ];
    }

    /**
     * @param Request $request
     * @return void
     * @throws BadRequestException
     */
    private function ajaxGuard(Request $request): void
    {
        if (! $request->ajax()) {
            throw new BadRequestException('You can only make ajax requests to this route');
        }
    }

}
