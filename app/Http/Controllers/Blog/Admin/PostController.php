<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\Admin\BlogPostRequest\BlogPostCreateRequest;
use App\Http\Requests\Admin\BlogPostRequest\BlogPostUpdateIsPublishedRequest;
use App\Http\Requests\Admin\BlogPostRequest\BlogPostUpdateRequest;
use App\Models\BlogPost;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogPostRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
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
        $perPage = 25;
        $paginator = $this->postRepository->getAllWithPaginator($perPage);
        return view('blog.admin.posts.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $item = new BlogPost();
        $categoryList = $this->categoryRepository->getDropDownList();
        return view('blog.admin.posts.edit', compact('item', 'categoryList'));
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
            return back()
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
     * @param int $id
     * @return View
     */
    public function edit($id)
    {
        $item = $this->postRepository->getExactPost($id);
        if (empty($item)) abort(404);
        $categoryList = $this->categoryRepository->getDropDownList();

        return view('blog.admin.posts.edit', compact('item', 'categoryList'));
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

    public function updateAjax(BlogPostUpdateIsPublishedRequest $request, BlogPost $post)
    {
        if ($request->ajax()) {
            $post->update($request->all());
            return ['success' => true];
        }
        throw new BadRequestException('You can only make ajax requests to this route');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        return $id;
//        BlogPost::find($id)->delete();
    }
}
