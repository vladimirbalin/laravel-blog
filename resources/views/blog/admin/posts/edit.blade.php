@extends('layouts.admin')
@section('content')
    @php /** @var \App\Models\BlogPost $item */ @endphp
    <div class="container">
        @include('blog.includes.session-msg')

        @if($item->exists)
            <form method="post" action="{{ route('blog.admin.posts.update', $item->id) }}">
                @method('PATCH')
        @else
            <form method="post" action="{{ route('blog.admin.posts.store') }}">
        @endif
                @csrf
                <div class="row">
                    <div class="col-md-8 py-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="title"><strong>Post title</strong></label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="title"
                                            name="title"
                                            placeholder="Please enter the title"
                                            value="{{ old('title', $item->title) }}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="slug"><strong>Slug/Unique Identifier</strong></label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="slug"
                                            name="slug"
                                            placeholder="Please enter the slug identifier"
                                            value="{{ old('slug', $item->slug) }}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="content_raw"><strong>Post body|Content_raw</strong></label>
                                        <textarea
                                            class="form-control"
                                            name="content_raw"
                                            id="content_raw"
                                            rows="8">{{ old('content_raw', $item->content_raw) }}</textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="excerpt">Excerpt</label>
                                        <textarea
                                            class="form-control"
                                            name="excerpt"
                                            id="excerpt"
                                            rows="2">{{ old('excerpt', $item->excerpt) }}</textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="category_id"><strong>Category</strong></label>
                                        <select
                                            class="form-control"
                                            name="category_id"
                                            id="category_id">
                                            @foreach($categoryList as $category)
                                                @php /** @var $category \App\Models\BlogCategory */ @endphp
                                                <option
                                                    value="{{ $category->id }}"
                                                    @if($category->id === (int)old('category_id', $item->category_id)) selected @endif
                                                >
                                                    {{ $category->select_title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 align-self-end is_published">
                                        <input type="hidden" name="is_published" value="0">
                                        <input type="checkbox"
                                               name="is_published"
                                               id="is_published"
                                               class="pt-2"
                                               value="1"
                                               @if($item->is_published) checked="checked" @endif>
                                        <label for="is_published">
                                            <strong>Published</strong>
                                        </label>
                                    </div>
                                </div>
                                @if($item->exists)
                                    <a type="button"
                                       class="btn btn-outline-danger"
                                       data-toggle="modal"
                                       data-target="#exampleModal">
                                        Delete
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 py-3">
                        @include('blog.includes.right-part')
                    </div>
                </div>
            </form>
    </div>
    @if($item->exists)
            <!-- Delete post form -->
        <form action="{{ route('blog.admin.posts.destroy', $item->id) }}"
              method="POST"
              id="destroy-post-form">
            @method('DELETE')
            @csrf
        </form>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure?
                </div>
                <div class="modal-footer">
                    <a onclick="event.preventDefault();
                               document.getElementById('destroy-post-form').submit();"
                               href="{{ route('blog.admin.posts.destroy', $item->id)  }}"
                       class="btn btn-secondary"
                       data-dismiss="modal">Delete post</a>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
