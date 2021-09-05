<button type="submit"
        class="btn btn-sm btn-outline-primary follow"
        onclick="document.getElementById('unfollow-{{$user->id}}').submit()">
    unfollow
</button>
<form action="{{ route('blog.profile.unfollow', $user->id) }}"
      method="post"
      id="unfollow-{{$user->id}}">
    @method('put')
    @csrf
</form>
