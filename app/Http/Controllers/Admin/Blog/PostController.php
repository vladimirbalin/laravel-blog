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
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Throwable;

class PostController extends BaseController
{
    public function __construct(
        private BlogPostRepository     $postRepository,
        private BlogCategoryRepository $categoryRepository
    )
    {
    }

    /**
     * Show all posts page
     *
     * @return View
     */
    public function index(): View
    {
        $postsPerPage = 12;
        $paginator = $this
            ->postRepository
            ->getAllWithPaginator($postsPerPage);

        return view(
            'admin.blog.posts.index',
            compact('paginator')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param BlogPost $post
     * @return View
     */
    public function create(BlogPost $post): View
    {
        $categoryList = $this
            ->categoryRepository
            ->getDropDownList();

        return view(
            'admin.blog.posts.edit',
            compact('post', 'categoryList')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogPostCreateRequest $request
     * @return RedirectResponse
     */
    public function store(
        BlogPostCreateRequest $request
    ): RedirectResponse
    {
        $post = new BlogPost();
        $post->fill($request->all());
        $post->save();

        return redirect()
            ->route('admin.blog.posts.index')
            ->with(['success' => 'Saved successfully']);
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
            ->categoryRepository
            ->getDropDownList();

        return view(
            'admin.blog.posts.edit',
            compact('post', 'categoryList')
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
        BlogPost              $post
    ): RedirectResponse
    {
        $post->fill($request->all());

        if (
            $post->isPublished() &&
            $post->neverPublishedBefore()
        ) {
            $post->publish();
        }

        $post->save();

        return redirect()
            ->route('admin.blog.posts.edit', compact('post'))
            ->with(['success' => 'Post saved successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BlogPost $post
     * @return RedirectResponse
     *
     * @throws Throwable
     */
    public function destroy(BlogPost $post): RedirectResponse
    {
        $post->deleteOrFail();

        return redirect()
            ->route('admin.blog.posts.index')
            ->with([
                'toRestore' => "Post with id [$post->id] deleted successfully",
                'post_id' => $post->id
            ]);
    }

    /**
     * Restore the specified post
     *
     * @param $id
     * @return RedirectResponse
     */
    public function postRestore($id): RedirectResponse
    {
        $result = BlogPost
            ::withTrashed()
            ->find($id)
            ->restore();

        if (! $result) {
            throw new NotFoundResourceException("Cannot restore post with id: $id");
        }

        return redirect()
            ->back()
            ->with(["success" => "Post with id [$id] restored successfully"]);
    }
}
