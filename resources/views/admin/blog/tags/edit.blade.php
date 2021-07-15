@extends('layouts.admin')
@section('content')
    @php /** @var \App\Models\BlogPost $tag */ @endphp
    <div class="container">
        @include('web.blog.includes.session-msg')

            <form method="post" action="{{ route('admin.blog.tags.update', $tag->id) }}">
                @if($tag->exists)
                    <form method="post" action="{{ route('admin.blog.tags.update', $tag->id) }}">
                        @method('PATCH')
                        @else
                            <form method="post" action="{{ route('admin.blog.tags.store') }}">
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
                                            value="{{ old('title', $tag->title) }}">
                                    </div>
                                </div>
                                @if($tag->exists)
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
                    </div>
                </div>
            </form>
    </div>
    @if($tag->exists)
            <!-- Delete post form -->
        <form action="{{ route('admin.blog.tags.destroy', $tag->id) }}"
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
                               href="{{ route('admin.blog.tags.destroy', $tag->id)  }}"
                       class="btn btn-secondary"
                       data-dismiss="modal">Delete post</a>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
