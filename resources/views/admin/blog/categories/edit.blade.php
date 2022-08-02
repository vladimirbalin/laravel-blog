@extends('layouts.admin')
@section('content')
    @php /** @var \App\Models\BlogCategory $category */ @endphp
    <div class="container">
        <x-session-message/>
        @if($category->exists)
            <form method="post" action="{{ route('admin.blog.categories.update', $category->id) }}">
                @method('PUT')
                @else
            <form method="post" action="{{ route('admin.blog.categories.store') }}">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-8 py-3">
                        @include('web.blog.includes.left-part-category')
                    </div>
                    <div class="col-md-4 py-3">
                        @include('web.blog.includes.save-button')
                        @include('web.blog.includes.post-or-category-right-part')
                    </div>

                </div>
            </form>
    </div>
@endsection
