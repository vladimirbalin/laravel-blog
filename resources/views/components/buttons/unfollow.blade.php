<form class="mt-3"
      action="{{ route($routeName, $userId) }}"
      method="post">
    @method('delete')
    @csrf
    <button type="submit"
            class="btn btn-sm btn-outline-primary follow">
        unfollow
    </button>
</form>
