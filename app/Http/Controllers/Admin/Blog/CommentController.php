<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use App\Models\BlogComment;
use App\Repositories\BlogCommentRepository;
use App\Http\Requests\Admin\BlogComment\BlogCommentUpdate;
use App\Http\Requests\Admin\BlogComment\BlogCommentUpdateIsPublishedRequest;

class CommentController extends Controller
{
    private $blogCommentRepository;

    public function __construct(BlogCommentRepository $blogCommentRepository)
    {
        $this->blogCommentRepository = $blogCommentRepository;
    }

    public function index()
    {
        $commentsPerPage = 12;
        $comments = $this->blogCommentRepository->getAllWithPaginator($commentsPerPage);

        return view('admin.blog.comments.index', compact('comments'));
    }

    public function edit(BlogComment $comment)
    {
        return view('admin.blog.comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     * Update published_at only when prev published_at is null
     * and current is_published is 1
     *
     * @param BlogCommentUpdate $request
     * @param $commentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogCommentUpdate $request, $commentId)
    {
        $comment = $this->blogCommentRepository->getExactComment($commentId);

        $status = $request->input('status');
        $comment->status = $status;
        if ($status && is_null($comment->published_at)) {
            $comment->published_at = now();
        }
        if (! $status) {
            $comment->published_at = null;
        }
        $result = $comment->save();

        if ($result) {
            return redirect()
                ->route('admin.blog.comments.edit', compact('comment'))
                ->with(['success' => 'Comment updated']);
        } else {
            return back()
                ->withInput()
                ->withErrors(['msg' => 'Save fail']);
        }
    }

    public function destroy(BlogComment $comment)
    {
        $comment->delete();

        return redirect()
            ->route('admin.blog.comments.index')
            ->with(['success' => 'Comment deleted']);
    }

    /**
     * Returns array with status key as 1 if published comment
     * or 0 to unpublished, published_at key as "d M H:m" formatted time
     * or null if not published
     *
     * @param \App\Http\Requests\Admin\BlogComment\BlogCommentUpdateIsPublishedRequest $request
     * @param BlogComment $comment
     * @return array
     */
    public function ajax(BlogCommentUpdateIsPublishedRequest $request,
                         BlogComment                         $comment)
    {
        if (!$request->ajax()) {
            throw new BadRequestException('You can only make ajax requests to this route');
        }

        $status = $request->input('status');
        $comment->status = $status;
        $comment->published_at = $status == 1 ? now() : null;
        $comment->save();

        return [
            'status' => $comment->status,
            'published_at' => $comment->getPublishedAtShortened()
        ];
    }
}
