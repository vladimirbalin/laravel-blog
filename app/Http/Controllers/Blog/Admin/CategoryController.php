<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = BlogCategory::paginate(5);
        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd(__METHOD__);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd(__METHOD__);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|
     * \Illuminate\Contracts\View\Factory|
     * \Illuminate\Contracts\View\View|
     * \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = BlogCategory::findOrFail($id);
        $categoryList = BlogCategory::all();
        return view('blog.admin.categories.edit', compact('category', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogCategoryUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        $model = BlogCategory::find($id);
        if (is_null($model)) {
            return back()
                ->withErrors(['msg' => "Category with [{$id}] id wasn't found"])
                ->withInput();
        }
        $result = $model->fill($request->all())->save();

        if ($result) {
            return back()
                ->with(['success' => 'Saved successfully']);
        } else {
            return back()->withInput()->withErrors(['msg' => 'Save fail']);
        }
    }

}
