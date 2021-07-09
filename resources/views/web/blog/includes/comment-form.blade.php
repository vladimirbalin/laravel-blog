<form action="{{ route('blog.comments.store') }}" method="POST" class="mb-3">
    @csrf
    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="content">Your comment</label>
            <textarea class="form-control" id="content" name="content"></textarea>

        </div>
        <input type="hidden" id="post_id" name="post_id" value="{{ $post->id }}">
        <div class="form-group col-md-12">
            <button class="btn btn-sm btn-primary float-right" type="submit">send comment</button>
        </div>
    </div>
</form>
