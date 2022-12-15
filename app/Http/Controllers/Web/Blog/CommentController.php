<?php

namespace App\Http\Controllers\Web\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\BlogCommentRequest;
use App\Models\BlogComment;
use Illuminate\Support\Arr;

class CommentController extends Controller
{
    public function destroy(BlogComment $comment)
    {
        $result = $comment->delete();

        if (! $result) {
            return back()->withErrors(['Cannot delete this comment']);
        }

        return back()->with(['success' => 'Comment successfully deleted']);
    }

    public function store(BlogCommentRequest $request)
    {
        $result = BlogComment::create($request->input());

        if (! $result) {
            return back()->withErrors(['Creation fail'])->withInput();
        }

        return back()->with(['success' => 'Comment successfully published now']);
    }
}
