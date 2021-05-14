<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\Admin\BlogCategoryCreateRequest;
use App\Http\Requests\Admin\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends BaseController
{
    protected $repository;

    public function __construct()
    {
        parent::__construct();

        $this->repository = app(BlogCategoryRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $perPage = 5;
        $paginator = $this->repository->getAllWithPagination($perPage);

        return view('blog.admin.categories.index',
            compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $category = new BlogCategory;
        $dropDownListCategories = $this->repository->getDropDownList();

        return view('blog.admin.categories.create',
            compact('category', 'dropDownListCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogCategoryCreateRequest $request
     * @return RedirectResponse
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $category = new BlogCategory;

        $result = $category->fill($request->input())->save();
        if ($result) {
            $paginator = BlogCategory::paginate($this->perPage);
            return redirect()->route('blog.admin.categories.index')
                ->setTargetUrl('?page=' . $paginator->lastPage())
                ->with('success', 'Category successfully saved.');
        }

        return back()->withInput()->withErrors(['msg' => 'Save fail']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return View
     */
    public function edit($id)
    {
        $category = $this->repository->getEdit($id);
        if (empty($category)) abort(404);
        $dropDownListCategories = $this->repository->getDropDownList();

        return view('blog.admin.categories.edit',
            compact('category', 'dropDownListCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogCategoryUpdateRequest $request
     * @param BlogCategory $category
     * @return RedirectResponse
     */
    public function update(BlogCategoryUpdateRequest $request, BlogCategory $category)
    {
        $result = $category->fill($request->input())->save();

        if ($result) {
            return back()
                ->with(['success' => 'Saved successfully']);
        } else {
            return back()->withInput()->withErrors(['msg' => 'Save fail']);
        }
    }

}
