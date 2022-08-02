@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-session-message/>
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                        <tr style="background-color: #afc2e8">
                            <th>#</th>
                            <th>Category</th>
                            <th>Parent</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($paginator as $category)
                            @php /** @var \App\Models\BlogCategory $category */ @endphp
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    <a href="{{ route('admin.blog.categories.edit', $category->id) }}">
                                        {{ $category->title }}
                                    </a>
                                </td>
                                <td>@if($category->parent_id < 2) no category @else{{ $category->parentCategory->title }}@endif</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @php /** @var \Illuminate\Pagination\Paginator $paginator */ @endphp
                    @if($paginator->total() > $paginator->count())
                        <div class="row justify-content-center">
                            {{ $paginator }}
                        </div>
                    @endif
                    <nav class="navbar navbar-toggleable-md navbar-light bg-faded justify-content-end">
                        <a href="{{ route('admin.blog.categories.create') }}" class="btn btn-primary">Add category</a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
