@extends('layouts.web')
@section('content')
    @php /** @var \App\Models\BlogPost $post */ @endphp
    <div class="container">
        <x-session-message/>

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
                                                <label for="title"><strong>Title</strong></label>
                                                <input
                                                    type="text"
                                                    class="form-control mb-3"
                                                    id="title"
                                                    name="title"
                                                    placeholder="Please enter the title"
                                                    value="{{ old('title', $post->title) }}">
                                                <input
                                                    type="hidden"
                                                    class="form-control mb-3"
                                                    id="slug"
                                                    name="slug"
                                                    value="{{ old('slug', $post->slug) }}">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="content_raw"><strong>Post</strong></label>
                                                <textarea
                                                    class="form-control mb-3"
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
                                @include('web.blog.includes.save-button')
                                <div class="card">
                                    <div class="card-body">

                                        <div class="form-group col">
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
                                </div>
                            </div>
                        </div>
                    </form>
    </div>

    @if($post->exists)
        <!-- Delete post form -->
        <form action="{{ route('blog.posts.destroy', $post->id) }}"
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
                           href="{{ route('blog.posts.destroy', $post->id)  }}"
                           class="btn btn-secondary"
                           data-dismiss="modal">Delete post</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
