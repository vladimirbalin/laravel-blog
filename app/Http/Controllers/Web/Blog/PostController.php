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
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class PostController extends BaseController
{
    private $blogPostRepository;
    private $blogCategoryRepository;
    private $blogCommentRepository;

    public function __construct(BlogPostRepository $blogPostRepository,
                                BlogCategoryRepository $blogCategoryRepository,
                                BlogCommentRepository $blogCommentRepository)
    {
        $this->blogPostRepository = $blogPostRepository;
        $this->blogCategoryRepository = $blogCategoryRepository;
        $this->blogCommentRepository = $blogCommentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $paginator = $this->blogPostRepository->getAllPublishedWithPaginator(10);

        return view('web.blog.posts.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(BlogPost $post)
    {
        $categoryList = $this->blogCategoryRepository->getDropDownList();

        return view('web.blog.posts.edit', compact('post', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogPostCreateRequest $request
     * @return View|RedirectResponse
     */
    public function store(BlogPostCreateRequest $request)
    {
        $result = BlogPost::create($request->input());
        if ($result) {
            return back()
                ->with(['success' => 'Post created']);
        } else {
            return back()
                ->withErrors('Creation failed')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param BlogPost $post
     * @return View
     */
    public function show($postId)
    {
        $post = $this->blogPostRepository->getExactPost($postId);
        $comments = $this->blogCommentRepository->getAllPublishedByPost($postId);

        return view('web.blog.posts.show', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BlogPost $post
     * @return View
     */
    public function edit(BlogPost $post)
    {
        $categoryList = $this->blogCategoryRepository->getDropDownList();

        if ($post->isAuthor()) {
            return view('web.blog.posts.edit', compact('post', 'categoryList'));
        }
        abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogPostUpdateRequest $request
     * @param BlogPost $post
     * @return RedirectResponse|void
     */
    public function update(BlogPostUpdateRequest $request, BlogPost $post)
    {
        $result = $post->update($request->all());

        if ($result) {
            return back()
                ->with(['success' => 'Successfully saved']);
        } else {
            return back()
                ->withInput()
                ->withErrors(['msg' => 'Save fail']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BlogPost $post
     * @return RedirectResponse
     */
    public function destroy(BlogPost $post)
    {
        $result = $post->delete();

        if ($result) {
            return redirect()->route('blog.posts.index')
                ->with(['success' => 'Post successfully removed!']);
        } else {
            return back()
                ->withInput()
                ->withErrors(['msg' => 'Save fail']);
        }
    }

    public function like(Request $request, BlogPost $post)
    {
        if ($request->ajax()) {
            $post->toggleLike();
            return ['success' => true, 'count' => $post->likedUsers()->count()];
        }

        throw new BadRequestException('You can only make ajax requests to this route');
    }
}
