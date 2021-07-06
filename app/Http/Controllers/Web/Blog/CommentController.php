<?php

namespace App\Http\Controllers\Web\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;

class CommentController extends Controller
{
    public function destroy(BlogComment $comment)
    {
        if($comment->delete()) return back()->with(['success' => 'Comment successfully deleted']);
    }
}
