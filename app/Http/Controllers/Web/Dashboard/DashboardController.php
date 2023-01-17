<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\BlogPostRepository;
use App\Repositories\BlogUserRepository;
use Illuminate\View\View;

class DashboardController extends Controller
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

        return view('web.dashboard', compact(
                'topPostsLastMonth',
                'topPostsLastYear',
                'topAuthorsLastMonth',
                'topAuthorsLastYear')
        );
    }
}
