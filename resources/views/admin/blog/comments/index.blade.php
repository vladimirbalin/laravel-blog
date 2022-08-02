@extends('layouts.admin')

@section('content')
    <div class="container content">
        <x-session-message/>

        <table class="table table-sm table-hover">
            <tr style="background-color: #afc2e8">
                <th>#</th>
                <th>Post</th>
                <th>Comment</th>
                <th>Author</th>
                <th>Status</th>
                <th>Created</th>
                <th>Published at</th>
            </tr>
            @foreach($comments as $comment)
                <tr data-status="{{ $comment->status }}"
                    data-comment-id="{{ $comment->id }}">
                    @php /** @var $comment \App\Models\BlogComment */ @endphp
                    <td class="align-middle">{{ $comment->id }}</td>
                    <td class="align-middle opacity-25-hover:hover">
                        <a class="link-info"
                           href="{{ route('admin.blog.posts.edit', $comment->post_id) }}">{{ \Illuminate\Support\Str::limit($comment->post->title, 35) }}</a>
                    </td>
                    <td class="align-middle">
                        <a class="link-info"
                           href="{{ route('admin.blog.comments.edit', $comment->id) }}">{{ \Illuminate\Support\Str::limit($comment->content, 35)  }}</a>
                    </td>
                    <td class="align-middle">{{ $comment->user->name }}</td>
                    <td class="align-middle">
                        <label class="switch">
                            <input type="checkbox"
                                   name="status"
                                   class="pt-2 status"
                                   data-route="{{ route('admin.blog.comments.ajax', $comment->id) }}"
                                   @if($comment->status) checked="checked" @endif>
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td class="align-middle">{{ $comment->getCreatedAtShortened() }}</td>
                    <td class="align-middle published_at">{{ $comment->getPublishedAtShortened() ?? 'Not published' }}</td>
                </tr>
            @endforeach
        </table>

        @if($comments->total() > $comments->count())
            {{ $comments }}
        @endif
    </div>
@endsection
