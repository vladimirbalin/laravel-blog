@extends('layouts.app')
@section('content')
    @php /** @var \App\Models\BlogPost $post */ @endphp
    <div class="container">
        @include('blog.includes.session-msg')

        @if($post->exists)
            <form method="post" action="{{ route('blog.admin.posts.update', $post->id) }}">
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
                                        <label for="title">*Post title</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="title"
                                            name="title"
                                            placeholder="Please enter the title"
                                            value="{{ old('title', $post->title) }}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="slug">Slug/Unique Identifier</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="slug"
                                            name="slug"
                                            placeholder="Please enter the slug identifier"
                                            value="{{ old('slug', $post->slug) }}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="slug">Post body</label>
                                        <textarea
                                            class="form-control"
                                            name="content_html"
                                            id="content_html"
                                            rows="3">{{ old('content_html', $post->content_html) }}</textarea>
                                    </div>
                                </div>
                                <button
                                    type="submit"
                                    class="btn btn-primary">Save
                                </button>
                                <form action="{{ route('blog.admin.posts.destroy', $post->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Delete">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
    </div>
@endsection
