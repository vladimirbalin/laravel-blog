<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\BlogPost\BlogPostCreateRequest;
use App\Http\Requests\Admin\BlogPost\BlogPostUpdateIsPublishedRequest;
use App\Http\Requests\Admin\BlogPost\BlogPostUpdateRequest;
use App\Models\BlogPost;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogPostRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class PostController extends BaseController
{
    private $postRepository;
    private $categoryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->postRepository = app(BlogPostRepository::class);
        $this->categoryRepository = app(BlogCategoryRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $postsPerPage = 12;
        $paginator = $this->postRepository->getAllWithPaginator($postsPerPage);

        return view('admin.blog.posts.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(BlogPost $post)
    {
        $categoryList = $this->categoryRepository->getDropDownList();

        return view('admin.blog.posts.edit', compact('post', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogPostCreateRequest $request
     * @return View|RedirectResponse
     */
    public function store(BlogPostCreateRequest $request)
    {
        $attributes = Arr::collapse([$request->all()]);
        $result = (new BlogPost())->create($attributes);

        if ($result) {
            return redirect()
                ->route('admin.blog.posts.index')
                ->with(['success' => 'Saved successfully']);
        } else {
            return back()
                ->withErrors(['Save fail'])
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BlogPost $post
     * @return View
     */
    public function edit(BlogPost $post)
    {
        $categoryList = $this->categoryRepository->getDropDownList();

        return view('admin.blog.posts.edit', compact('post', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     * Update published_at only when prev published_at is null
     * and current is_published is 1
     *
     * @param BlogPostUpdateRequest $request
     * @param BlogPost $post
     * @return RedirectResponse
     */
    public function update(BlogPostUpdateRequest $request, BlogPost $post)
    {
        $post->status = $request->status;
        if ($post->isPublished() && is_null($post->published_at)) {
            $post->published_at = now();
        }
        if ($post->isNotPublished()) {
            $post->published_at = null;
        }
        $result = $post->save();

        if ($result) {
            return redirect()
                ->route('admin.blog.posts.edit', compact('post'))
                ->with(['success' => 'Successfully saved']);
        } else {
            return back()
                ->withInput()
                ->withErrors(['msg' => 'Save fail']);
        }
    }

    public function ajax(BlogPostUpdateIsPublishedRequest $request, BlogPost $post)
    {
        if (!$request->ajax()) {
            throw new BadRequestException('You can only make ajax requests to this route');
        }
        $is_published = $request->is_published;

        $post->is_published = $is_published;
        $post->published_at = $is_published == 1 ? now() : null;
        $post->save();

        return [
            'is_published' => $post->is_published,
            'published_at' => $post->getPublishedAtShortened()
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $result = BlogPost::destroy($id);

        if ($result) {
            return redirect()
                ->route('admin.blog.posts.index')
                ->with(['toRestore' => "Post with id [$id] deleted successfully",
                    'post_id' => $id]);
        } else {
            return back()
                ->withErrors(['msg' => 'Delete failed']);
        }
    }

    public function restore($id)
    {
        $result = BlogPost::withTrashed()
            ->where(['id' => $id])
            ->restore();

        if ($result) {
            return redirect()
                ->route('admin.blog.posts.index')
                ->with(['success' => "Post with id [$id] restored successfully"]);
        } else {
            return back()
                ->withErrors(['msg' => 'Restore failed']);
        }

    }
}
