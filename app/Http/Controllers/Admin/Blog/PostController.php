<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\BlogPost\BlogPostCreateRequest;
use App\Http\Requests\Admin\BlogPost\BlogPostUpdateRequest;
use App\Models\BlogPost;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogPostRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;

class PostController extends BaseController
{
    public function __construct(
        private BlogPostRepository     $postRepository,
        private BlogCategoryRepository $categoryRepository
    )
    {
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
        $post->fill($request->toArray());
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

    /**
     * Restore the specified post
     *
     * @param $id
     * @return RedirectResponse
     */

    public function postRestore($id)
    {
        $result = BlogPost::withTrashed()
            ->where(['id' => $id])
            ->restore();

        if ($result) {
            return redirect()
                ->back()
                ->with(["success" => "Post with id [$id] restored successfully"]);
        } else {
            return back()
                ->withErrors(["msg" => "Restore failed"]);
        }
    }
}
