@extends('layouts.admin')
@section('content')
    @php /** @var \App\Models\BlogCategory $item */ @endphp
    <div class="container">
        @include('blog.includes.session-msg')
        @if($item->exists)
            <form method="post" action="{{ route('blog.admin.categories.update', $item->id) }}">
                @method('PUT')
                @else
            <form method="post" action="{{ route('blog.admin.categories.store') }}">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-8 py-3">
                        @include('blog.includes.left-part')
                    </div>
                    <div class="col-md-4 py-3">
                        @include('blog.includes.right-part')
                    </div>

                </div>
            </form>
    </div>
@endsection
