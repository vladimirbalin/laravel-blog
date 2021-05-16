@extends('layouts.app')
@section('content')
    @php /** @var \App\Models\BlogPost $item */ @endphp
    <div class="container">
        @include('blog.includes.session-msg')

        @if($item->exists)
            <form method="post" action="{{ route('blog.admin.posts.update', $item->id) }}">
                @method('PUT')
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
                                        <label for="content_raw"><strong>Post body</strong></label>
                                        <textarea
                                            class="form-control"
                                            name="content_html"
                                            id="content_raw"
                                            rows="8">{{ old('content_raw', $item->content_raw) }}</textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="excerpt">Excerpt</label>
                                        <textarea
                                            class="form-control"
                                            name="excerpt"
                                            id="excerpt"
                                            rows="2">{{ old('content_html', $item->excerpt) }}</textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="category"><strong>Category</strong></label>
                                        <select
                                            class="form-control"
                                            name="category"
                                            id="category">
                                            @foreach($categoryList as $category)
                                                @php /** @var $category \App\Models\BlogCategory */ @endphp
                                                <option
                                                    @if($category->id === $item->category_id) selected @endif>
                                                    {{ $category->select_title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 align-self-end published">
                                        <input type="hidden" name="published" value="0">
                                        <input type="checkbox"
                                               name="published"
                                               id="published"
                                               class="pt-2"
                                               value="1"
                                               @if($item->is_published) checked="checked" @endif>
                                        <label for="published">
                                            <strong>Published</strong>
                                        </label>

                                    </div>
                                </div>
                                <a href="{{ route('blog.admin.posts.destroy', $item->id)  }}"
                                   onclick="event.preventDefault();
                               document.getElementById('destroy-post-form').submit();"
                                   class="btn btn-outline-danger">
                                    Delete post
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 py-3">
                        @include('blog.includes.right-part')
                    </div>
                </div>
            </form>
    </div>

    <form action="{{ route('blog.admin.posts.destroy', $item->id) }}"
          method="POST"
          id="destroy-post-form">
        @method('DELETE')
        @csrf
    </form>
@endsection
