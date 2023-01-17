<?php

namespace App\Http\Controllers\Web\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\BlogCommentRequest;
use App\Models\BlogComment;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function destroy(BlogComment $comment): RedirectResponse
    {
        $comment->delete();

        return back()->with(['success' => 'Comment successfully deleted']);
    }

    public function store(BlogCommentRequest $request): RedirectResponse
    {
        BlogComment::create($request->all());

        return back()->with(['success' => 'Comment successfully published now']);
    }
}
