@php /** @var $comment \App\Models\BlogComment */ @endphp
<div class="card my-2">
    <div class="card-body">
        <div class="card-title">
            <a class="text-decoration-none" href="{{ route('blog.profile.show', $comment->user_id) }}">
                <strong>{{ $comment->author }}</strong></a>
        </div>
        <p class="card-text">
            {{ $comment->content }}
        </p>
        <p class="float-right text-muted">{{ $comment->created_at->longRelativeDiffForHumans() }}</p>
        @if($comment->isAuthor())
            <a href="{{ route('blog.comments.delete', $comment->id) }}"
               type="button"
               onclick="event.preventDefault();
                               document.getElementById('destroy-comment-form').submit();"
               class="btn btn-outline-danger float-end">
                Delete
            </a>
            @if($comment->exists)
                <!-- Delete comment form -->
                <form action="{{route('blog.comments.delete', $comment->id)}}"
                      method="POST"
                      id="destroy-comment-form">
                    @method('DELETE')
                    @csrf
                </form>
            @endif
        @endif
    </div>
</div>
