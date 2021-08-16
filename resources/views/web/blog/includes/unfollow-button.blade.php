<form action="{{ route('blog.posts.unfollow', $user->id) }}"
      method="post">
    @method('put')
    @csrf
    <button type="submit"
            class="btn btn-sm btn-outline-primary follow">unfollow</button>
</form>
