<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\BlogCategory\BlogCategoryCreateRequest;
use App\Http\Requests\Admin\BlogCategory\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class CategoryController extends BaseController
{
    protected $perPage = 10;

    public function __construct(
        protected BlogCategoryRepository $blogCategoryRepository
    )
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $paginator = $this
            ->blogCategoryRepository
            ->getAllWithPagination($this->perPage);

        return view(
            'admin.blog.categories.index',
            compact('paginator')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $category = new BlogCategory;
        $dropDownListCategories = $this
            ->blogCategoryRepository
            ->getDropDownList();

        return view(
            'admin.blog.categories.create',
            compact('category', 'dropDownListCategories')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogCategoryCreateRequest $request
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function store(
        BlogCategoryCreateRequest $request
    ): RedirectResponse
    {
        $category = new BlogCategory;

        $category
            ->fill($request->all())
            ->save();

        $paginator = BlogCategory::paginate($this->perPage);

        return redirect()
            ->route('admin.blog.categories.index')
            ->setTargetUrl('?page=' . $paginator->lastPage())
            ->with('success', 'Category successfully saved.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BlogCategory $category
     * @return View
     */
    public function edit(BlogCategory $category): View
    {
        $dropDownListCategories = $this
            ->blogCategoryRepository
            ->getDropDownList();

        return view('admin.blog.categories.edit',
            compact(
                'category',
                'dropDownListCategories'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogCategoryUpdateRequest $request
     * @param BlogCategory $category
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function update(
        BlogCategoryUpdateRequest $request,
        BlogCategory              $category
    ): RedirectResponse
    {
        $category->fill(
            $request->all()
        )->save();

        return back()->with(['success' => 'Saved successfully']);
    }

}
