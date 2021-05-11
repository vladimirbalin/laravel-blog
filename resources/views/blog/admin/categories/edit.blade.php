@extends('layouts.app')
@section('content')
    @php /** @var \App\Models\BlogCategory $category */ @endphp
    <div class="container">
        @php /** @var \Illuminate\Support\ViewErrorBag $errors */ @endphp
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show my-4" role="alert">
                {{ $errors->first() }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show my-4" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <form method="post" action="{{ route('blog.admin.categories.update', $category->id) }}">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-8 py-3">
                    @include('blog.admin.categories.includes.left-part')
                </div>
                <div class="col-md-3 py-3">
                    @include('blog.admin.categories.includes.right-part')
                </div>

            </div>
        </form>
    </div>
@endsection
