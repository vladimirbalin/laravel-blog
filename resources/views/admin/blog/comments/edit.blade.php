@extends('layouts.admin')
@section('content')
    @php /** @var \App\Models\BlogComment $comment */ @endphp
    <div class="container">
        @include('web.blog.includes.session-msg')

        @if($comment->exists)
            <form method="post" action="{{ route('admin.blog.comments.update', $comment->id) }}">
                @method('PATCH')
                @else
                    <form method="post" action="{{ route('admin.blog.comments.store') }}">
                        @endif
                        @csrf
                        <div class="row">
                            <div class="col-md-8 py-3">
                                <div class="card">
                                    <div class="card-header">
                                        <p>
                                            Post ID: <strong>{{ $comment->post_id }}</strong>
                                            Post title:
                                            <strong>
                                                <a href="{{route('admin.blog.posts.edit', $comment->post_id)}}">
                                                    {{ $comment->post->title }}
                                                </a>
                                            </strong>
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="content"><strong>Content</strong></label>
                                                <textarea
                                                    class="form-control"
                                                    id="content"
                                                    name="content"
                                                    placeholder="Comment content">{{ old('content', $comment->content) }}</textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                            </div>
                                            <div class="form-group col-md-12">
                                            </div>
                                            <div class="form-group col-md-6 align-self-end">
                                                <label for="status">
                                                    <strong>Status</strong>
                                                </label>
                                                <select name="status" id="status">
                                                    @foreach($comment->statuses as $key => $status)
                                                        <option value="{{ $key }}"
                                                        @if($key === $comment->status) selected @endif>{{ $status }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @if($comment->exists)
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
                                <div class="card my-2">
                                    <div class="card-body">
                                        <p>
                                            Comment ID: <strong>{{$comment->id}}</strong>
                                        </p>
                                    </div>
                                    @if($comment->user_id)
                                        <div class="card-body">
                                            <p>
                                                Author: <strong>{{$comment->user->name}}</strong>
                                            </p>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <p>
                                            Created at: <strong>{{$comment->created_at}}</strong>
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        <p>
                                            Updated at: <strong>{{$comment->updated_at}}</strong>
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        <p>
                                            Deleted at: <strong>{{$comment->deleted_at}}</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
    </div>
    @if($comment->exists)
        <!-- Delete post form -->
        <form action="{{ route('admin.blog.comments.destroy', $comment->id) }}"
              method="POST"
              id="destroy-comment-form">
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
                               document.getElementById('destroy-comment-form').submit();"
                           href="{{ route('admin.blog.comments.destroy', $comment->id)  }}"
                           class="btn btn-secondary"
                           data-dismiss="modal">Delete post</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
