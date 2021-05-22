<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\Admin\BlogCategoryRequest\BlogCategoryCreateRequest;
use App\Http\Requests\Admin\BlogCategoryRequest\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends BaseController
{
    protected $repository;
    protected $perPage = 5;

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
        $paginator = $this->repository->getAllWithPagination($this->perPage);

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
        $item = new BlogCategory;
        $dropDownListCategories = $this->repository->getDropDownList();

        return view('blog.admin.categories.create',
            compact('item', 'dropDownListCategories'));
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
        $item = $this->repository->getEdit($id);
        if (empty($item)) abort(404);
        $dropDownListCategories = $this->repository->getDropDownList();

        return view('blog.admin.categories.edit',
            compact('item', 'dropDownListCategories'));
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
