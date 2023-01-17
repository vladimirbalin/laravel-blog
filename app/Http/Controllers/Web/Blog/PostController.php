<?php

namespace App\Http\Controllers\Web\Blog;

use App\Http\Controllers\Web\BaseController;
use App\Http\Requests\Web\BlogPost\BlogPostCreateRequest;
use App\Http\Requests\Web\BlogPost\BlogPostUpdateRequest;
use App\Models\BlogPost;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogCommentRepository;
use App\Repositories\BlogPostRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends BaseController
{
    public function __construct(
        private BlogPostRepository     $blogPostRepository,
        private BlogCategoryRepository $blogCategoryRepository,
        private BlogCommentRepository  $blogCommentRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $paginator = $this
            ->blogPostRepository
            ->getAllPublishedWithPaginatorByCategorySortedBy(
                $request->get('sort'),
                $request->get('category')
            );
        $paginator->withQueryString();

        $categoryDropdown = $this->blogCategoryRepository->getDropDownList();

        return view('web.blog.posts.index',
            compact(
                'paginator',
                'categoryDropdown'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(BlogPost $post): View
    {
        $categoryList = $this
            ->blogCategoryRepository
            ->getDropDownList();

        return view(
            'web.blog.posts.edit',
            compact('post', 'categoryList')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogPostCreateRequest $request
     * @return RedirectResponse
     */
    public function store(BlogPostCreateRequest $request): RedirectResponse
    {
        BlogPost::create($request->all());

        return redirect()
            ->route('blog.posts.index')
            ->with(['success' => 'Post was successfully created']);
    }

    /**
     * Display the specified BlogPost page.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        $post = $this
            ->blogPostRepository
            ->getExactPostBySlug($slug);

        $comments = $this
            ->blogCommentRepository
            ->getAllPublishedByPost($post->id);

        return view(
            'web.blog.posts.show',
            compact(
                'post',
                'comments'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BlogPost $post
     * @return View
     */
    public function edit(BlogPost $post): View
    {
        $categoryList = $this
            ->blogCategoryRepository
            ->getDropDownList();

        if (! $post->isAuthor()) {
            abort(401);
        }

        return view(
            'web.blog.posts.edit',
            compact(
                'post',
                'categoryList'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogPostUpdateRequest $request
     * @param BlogPost $post
     * @return RedirectResponse
     */
    public function update(
        BlogPostUpdateRequest $request,
        BlogPost $post
    ): RedirectResponse
    {
        $post->update($request->all());

        return back()->with(['success' => 'Successfully saved']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BlogPost $post
     * @return RedirectResponse
     */
    public function destroy(BlogPost $post): RedirectResponse
    {
        $post->delete();

        return redirect()
            ->route('blog.posts.index')
            ->with(['success' => 'Post successfully removed!']);
    }

}
