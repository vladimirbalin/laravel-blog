<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogTagRequest;
use App\Models\BlogTag;
use App\Repositories\BlogTagRepository;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private $blogTagRepository;

    public function __construct(BlogTagRepository $blogTagRepository)
    {
        $this->blogTagRepository = $blogTagRepository;
    }

    public function index()
    {
        $tags = $this->blogTagRepository->getAll();

        return view('admin.blog.tags.index', compact('tags'));
    }

    public function create()
    {
        //
    }

    public function edit(BlogTag $tag)
    {
        return view('admin.blog.tags.edit', compact('tag'));
    }

    public function store(BlogTagRequest $request)
    {
        BlogTag::create($request->all());

        return redirect()->route('admin.blog.tags.index')->with(['success' => 'created']);
    }

    public function update(BlogTagRequest $request, BlogTag $tag)
    {
        $tag->update($request->all());

        return redirect()->route('admin.blog.tags.index')->with(['success' => 'saved']);
    }

    public function destroy($id)
    {
        //
    }
}
