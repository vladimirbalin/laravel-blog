@php /** @var $comment \App\Models\BlogComment */ @endphp
<div class="card">
    <div class="card-body">
        <div class="card-title">
            <strong>{{ $comment->getAuthor() }}</strong>
        </div>
        <p class="card-text">
            {{ $comment->content }}
            <span class="float-right">{{ $comment->created_at->longRelativeDiffForHumans() }}</span>
        </p>
        @if($comment->isAuthor())
            <a href="{{ route('blog.comments.delete', $comment->id) }}"
                type="button"
               onclick="event.preventDefault();
                               document.getElementById('destroy-comment-form').submit();"
                class="btn btn-outline-danger float-right">
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
