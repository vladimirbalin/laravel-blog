@extends('layouts.admin')

@section('content')
    <div class="container content">
        @include('web.blog.includes.session-msg')
        @if($comments->total() > $comments->count())
            {{ $comments }}
        @endif
        <table class="table table-sm table-hover">
            <tr>
                <th>#</th>
                <th>Post</th>
                <th>Content</th>
                <th>Author</th>
                <th>Status</th>
                <th>Created</th>
                <th>Published at</th>
            </tr>
            @foreach($comments as $comment)
                <tr>
                    @php /** @var $comment \App\Models\BlogComment */ @endphp
                    <td>{{ $comment->id }}</td>
                    <td>
                        <a href="{{ route('admin.blog.posts.edit', $comment->post_id) }}">{{ \Illuminate\Support\Str::limit($comment->post->title, 50) }}</a>
                    </td>
                    <td><a href="{{ route('admin.blog.comments.edit', $comment->id) }}">{{ $comment->content }}</a>
                    </td>
                    <td>{{ $comment->user->name }}</td>
                    <td>{{ $comment->getStatusText() }}</td>
                    <td>{{ $comment->getCreatedAtShortened() }}</td>
                    <td>{{ $comment->getPublishedAtShortened() }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
