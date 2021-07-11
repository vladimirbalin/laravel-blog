<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogComment\BlogCommentUpdate;
use App\Models\BlogComment;
use App\Repositories\BlogCommentRepository;

class BlogCommentController extends Controller
{
    private $blogCommentRepository;

    public function __construct(BlogCommentRepository $blogCommentRepository)
    {
        $this->blogCommentRepository = $blogCommentRepository;
    }

    public function index()
    {
        $comments = $this->blogCommentRepository->getAll();
        return view('admin.blog.comments.index', compact('comments'));
    }

    public function edit(BlogComment $comment)
    {
        return view('admin.blog.comments.edit', compact('comment'));
    }

    public function update(BlogCommentUpdate $request, $commentId)
    {
        $comment = $this->blogCommentRepository->getExactComment($commentId);
        $comment->update($request->all());

        return back()->with(['success' => 'Comment updated']);
    }

    public function destroy(BlogComment $comment)
    {
        $comment->delete();

        return redirect()
            ->route('admin.blog.comments.index')
            ->with(['success' => 'Comment deleted']);
    }
}
