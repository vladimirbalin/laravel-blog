<?php

namespace App\Http\Controllers;


use App\Repositories\BlogPostRepository;
use App\Repositories\BlogUserRepository;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private BlogPostRepository $blogPostRepository,
        private BlogUserRepository $blogUserRepository)
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return View
     */
    public function index()
    {
        $topPostsLastMonth = $this->blogPostRepository
            ->topByLikes(10, 1);
        $topPostsLastYear = $this->blogPostRepository
            ->topByLikes(10, 12);

        $topAuthorsLastMonth = $this->blogUserRepository
            ->topByLikes(10, 1);
        $topAuthorsLastYear = $this->blogUserRepository
            ->topByLikes(10, 12);

        return view('web.home', compact(
                'topPostsLastMonth',
                'topPostsLastYear',
                'topAuthorsLastMonth',
                'topAuthorsLastYear')
        );
    }

    public function adminIndex()
    {
        return view('admin.home');

    }
}
