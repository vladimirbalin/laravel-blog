@extends('layouts.app')
@section('content')
    @php /** @var \App\Models\BlogPost $post */ @endphp
    <div class="container">
        @include('web.blog.includes.session-msg')

        @if($post->exists)
            <form method="post" action="{{ route('blog.posts.update', $post->id) }}">
                @method('PATCH')
        @else
            <form method="post" action="{{ route('blog.posts.store') }}">
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
                                            value="{{ old('title', $post->title) }}">
                                        <input
                                            type="hidden"
                                            class="form-control"
                                            id="slug"
                                            name="slug"
                                            value="{{ old('slug', $post->slug) }}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="content_raw"><strong>Post body|Content_raw</strong></label>
                                        <textarea
                                            class="form-control"
                                            name="content_raw"
                                            id="content_raw"
                                            rows="8">{{ old('content_raw', $post->content_raw) }}</textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="excerpt">Excerpt</label>
                                        <textarea
                                            class="form-control"
                                            name="excerpt"
                                            id="excerpt"
                                            rows="2">{{ old('excerpt', $post->excerpt) }}</textarea>
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
                                                    @if($category->id === (int)old('category_id', $post->category_id)) selected @endif
                                                >
                                                    {{ $category->select_title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @if($post->exists)
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
                        @include('web.blog.includes.right-part')
                    </div>
                </div>
            </form>
    </div>
@endsection
