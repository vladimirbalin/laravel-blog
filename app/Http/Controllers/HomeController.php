<?php

namespace App\Http\Controllers;


use App\Repositories\BlogPostRepository;
use App\Repositories\BlogUserRepository;

class HomeController extends Controller
{

    private $blogPostRepository;
    private $blogUserRepository;

    public function __construct(BlogPostRepository $blogPostRepository,
                                BlogUserRepository $blogUserRepository)
    {
        $this->blogPostRepository = $blogPostRepository;
        $this->blogUserRepository = $blogUserRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
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
            ->topByLikes(10,12);

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
