@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show my-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <nav class="navbar navbar-toggleable-md navbar-light bg-faded justify-content-end">
                    <a href="{{ route('blog.admin.categories.create') }}" class="btn btn-primary">Добавить</a>
                </nav>
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Категория</th>
                            <th>Родитель</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($paginator as $category)
                            @php /** @var \App\Models\BlogCategory $category */ @endphp
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    <a href="{{ route('blog.admin.categories.edit', $category->id) }}">
                                        {{ $category->title }}
                                    </a>
                                </td>
                                <td>@if($category->parent_id < 2) no category @else{{ $category->parent_id }}@endif</td>
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
                </div>
            </div>
        </div>
    </div>
@endsection
