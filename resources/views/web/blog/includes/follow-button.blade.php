<form action="{{ route('blog.posts.follow', $user->id) }}" method="post">
    @method('put')
    @csrf
    <button type="submit"
            class="btn btn-sm btn-outline-primary follow">follow</button>
</form>
