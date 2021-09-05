<form action="{{ route('blog.profile.follow', $post->user->id) }}" method="post">
    @csrf
    <button type="submit"
            class="btn btn-sm btn-outline-primary follow">follow</button>
</form>
