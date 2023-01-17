<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogTagRequest;
use App\Models\BlogTag;
use App\Repositories\BlogTagRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TagController extends Controller
{
    public function __construct(
        private BlogTagRepository $blogTagRepository
    )
    {
    }

    public function index(): View
    {
        $tags = $this
            ->blogTagRepository
            ->getAll();

        return view(
            'admin.blog.tags.index',
            compact('tags')
        );
    }

    public function create()
    {
        //
    }

    public function edit(BlogTag $tag): View
    {
        return view('admin.blog.tags.edit', compact('tag'));
    }

    public function store(BlogTagRequest $request): RedirectResponse
    {
        BlogTag::create($request->all());

        return redirect()
            ->route('admin.blog.tags.index')
            ->with(['success' => 'created']);
    }

    public function update(
        BlogTagRequest $request,
        BlogTag $tag
    ): RedirectResponse
    {
        $tag->update($request->all());

        return redirect()
            ->route('admin.blog.tags.index')
            ->with(['success' => 'saved']
            );
    }

    public function destroy($id)
    {
        //
    }
}
