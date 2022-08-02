@php /** @var \Illuminate\Support\ViewErrorBag $errors */ @endphp

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        @foreach($errors->all() as $error)
            <span>{{$error}}</span><br>
        @endforeach
        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show my-4" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('toRestore'))
    <div class="alert alert-success alert-dismissible fade show my-4" role="alert">
        {{ session('toRestore') }}
        <a onclick="event.preventDefault();
                               document.getElementById('restore-post-form').submit();"
           href="{{ route('admin.blog.posts.restore', session('post_id'))  }}"
           class="btn btn-secondary"
           data-dismiss="modal">Restore?</a>
        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
    </div>
    <form action="{{ route('admin.blog.posts.restore', session('post_id')) }}"
          method="POST"
          id="restore-post-form">
        @method('PATCH')
        @csrf
    </form>
@endif
