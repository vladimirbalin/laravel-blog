@extends('layouts.app')
@section('content')
    @php /** @var \App\Models\BlogPost $post */ @endphp
    <div class="container">

        <div class="row">
            <div class="col-md-8 py-3">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('blog.posts.index') }}"
                           class="btn btn-outline-dark">Back to posts</a>
                        <div class="form-row">
                            <div class="col mx-auto my-2">
                                <h2>{{ $post->title }}</h2>
                                <p>{{ $post->content_html }}</p>
                                @if($post->isAuthor())
                                    <a href="{{ route('blog.posts.edit', $post->id) }}" class="btn btn-dark float-left">Edit</a>
                                    <a type="button"
                                       class="btn btn-outline-danger float-right"
                                       data-toggle="modal"
                                       data-target="#exampleModal">
                                        Delete
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-4 py-3">
                <div class="card my-2">
                    <div class="card-body">
                        <p>
                            Author: <strong>{{$post->user->name}}</strong>
                        </p>
                    </div>
                    <div class="card-body">
                        <p>
                            Created at: <strong>{{$post->createdAtRelatedTime()}}</strong>
                        </p>
                    </div>
                    <div class="card-body">
                        <p>
                            Updated at: <strong>{{$post->updatedAtRelatedTime()}}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
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
