<?php

namespace App\Http\Controllers\Admin\Blog;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use App\Repositories\BlogCommentRepository;
use App\Http\Requests\Admin\BlogComment\BlogCommentUpdate;

class CommentController extends Controller
{
    public function __construct(
        private BlogCommentRepository $blogCommentRepository
    )
    {
    }

    /**
     * Shows all comments page
     *
     * @return View
     */
    public function index(): View
    {
        $commentsPerPage = 12;
        $comments = $this
            ->blogCommentRepository
            ->getAllWithPaginator($commentsPerPage);

        return view(
            'admin.blog.comments.index',
            compact('comments')
        );
    }

    /**
     * Shows edit comment form
     *
     * @param BlogComment $comment
     * @return View
     */
    public function edit(BlogComment $comment): View
    {
        return view(
            'admin.blog.comments.edit',
            compact('comment')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogCommentUpdate $request
     * @param int $commentId
     * @return RedirectResponse
     *
     */
    public function update(
        BlogCommentUpdate $request,
        int               $commentId
    ): RedirectResponse
    {
        $comment = $this
            ->blogCommentRepository
            ->getExactComment($commentId);

        $comment->fill($request->safe()->toArray());

        if (
            $comment->isPublished() &&
            $comment->neverPublishedBefore()
        ) {
            $comment->publish();
        }

        $comment->save();

        return redirect()
            ->route('admin.blog.comments.edit', compact('comment'))
            ->with(['success' => 'Comment updated successfully!']);
    }

    public function destroy(BlogComment $comment): RedirectResponse
    {
        $comment->delete();

        return redirect()
            ->route('admin.blog.comments.index')
            ->with(['success' => 'Comment deleted']);
    }

}
