<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\RedirectResponse;

class HomeController
{
    public function __invoke(): RedirectResponse
    {
        return redirect()->route('blog.posts.index');
    }
}
