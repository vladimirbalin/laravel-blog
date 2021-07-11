@extends('layouts.admin')

@section('content')
    <div class="container content">
        @include('web.blog.includes.session-msg')
        <table class="table table-sm table-hover">
            <tr>
                <th>id</th>
                <th>post title</th>
                <th>content</th>
                <th>author</th>
                <th>status</th>
                <th>created</th>
                <th>published</th>
            </tr>
            @foreach($comments as $comment)
                <tr>
                    @php /** @var $comment \App\Models\BlogComment */ @endphp
                    <td>{{ $comment->id }}</td>
                    <td><a href="{{ route('admin.blog.posts.edit', $comment->post_id) }}">{{ \Illuminate\Support\Str::limit($comment->post->title, 50) }}</a></td>
                    <td><a href="{{ route('admin.blog.comments.edit', $comment->id) }}">{{ $comment->content }}</a>
                        </td>
                    <td>{{ $comment->user->name }}</td>
                    <td>{{ $comment->getStatus() }}</td>
                    <td>{{ $comment->getCreatedAtShortened() }}</td>
                    <td>{{ $comment->getPublishedAtShortened() }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
