@extends('layouts.app')

@section('content')
    <div class="container content">
        @include('web.blog.includes.session-msg')
        <a href="{{ route('blog.posts.create') }}" class="btn btn-primary m-3">Create post</a>
        <table class="table table-sm table-hover">
            <thead>
            <tr style="background-color: #afc2e8">
                <th>#</th>
                <th>Author</th>
                <th>Category</th>
                <th>Title</th>
                <th>Published at</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($paginator as $post)
                @php /** @var \App\Models\BlogPost $post */ @endphp
                <tr data-id="{{$post->id}}">
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->user->name }}</td>
                    <td>{{ $post->category->title }}</td>
                    <td>
                        <a href="{{ route('blog.posts.show', $post->id) }}">
                            {{ \Illuminate\Support\Str::limit($post->title, 30) }}
                        </a>
                    </td>
                    <td>{{ \Illuminate\Support\Carbon::parse($post->published_at)->format('d M H:m') }}</td>
                    <td>
                        @if(!$post->isAuthor())
                            <button title="Love it"
                                    class=
                                    "like likes-counter
                                        {{ $post->isLiked() ? 'active' : '' }}"
                                    data-count="{{ $post->likesCount() }}"
                                    data-route="{{ route('blog.posts.likePostAjax', $post->id) }}"
                                    data-id="{{ $post->id }}">
                                <span class="text-center">
                                    &#x2764;
                                </span>
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @php /** @var \Illuminate\Pagination\Paginator $paginator */ @endphp
        @if($paginator->total() > $paginator->count())
            <div class="row justify-content-center">
                {{ $paginator }}
            </div>
        @endif
    </div>
@endsection
