<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\Admin\BlogCategoryCreateRequest;
use App\Http\Requests\Admin\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends BaseController
{
    protected $perPage = 5;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $paginator = BlogCategory::paginate($this->perPage);
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
        $categoryList = BlogCategory::all();
        return view('blog.admin.categories.create',
            compact('category', 'categoryList'));
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

        $result = $category->fill($request->all())->save();
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
     * @param BlogCategory $category
     * @return View
     */
    public function edit(BlogCategory $category)
    {
        $categoryList = BlogCategory::all();
        return view('blog.admin.categories.edit',
            compact('category', 'categoryList'));
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
        if (is_null($category)) {
            return back()
                ->withErrors(['msg' => "Category with [{$id}] id wasn't found"])
                ->withInput();
        }
        $result = $category->fill($request->all())->save();

        if ($result) {
            return back()
                ->with(['success' => 'Saved successfully']);
        } else {
            return back()->withInput()->withErrors(['msg' => 'Save fail']);
        }
    }

}
