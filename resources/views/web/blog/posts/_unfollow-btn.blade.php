<form action="{{ route('blog.profile.unfollow', $post->user->id) }}"
      method="post">
    @method('delete')
    @csrf
    <button type="submit"
            class="btn btn-sm btn-outline-primary follow">unfollow</button>
</form>
