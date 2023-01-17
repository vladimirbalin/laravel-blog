<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;

class HomeController
{
    public function __invoke(): RedirectResponse
    {
        return redirect()->route('admin.blog.posts.index');
    }
}
