<form class="mt-3" action="{{ route($routeName, $userId) }}" method="post">
    @csrf
    <button type="submit"
            class="btn btn-sm btn-outline-primary follow">
        follow
    </button>
</form>
