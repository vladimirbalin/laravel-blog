@extends('layouts.admin')

@section('content')
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <ul class="list-unstyled p-3">
                            <li>Total users registered: {{ \App\Models\User::count() }}</li>
                            <li>Total blog posts: {{ \App\Models\BlogPost::count() }}</li>
                            <li>Total comments: {{ \App\Models\BlogComment::count() }}</li>
                            <li>Total likes: {{ \Illuminate\Support\Facades\DB::table('blog_post_user')->count() }}</li>
                        </ul>
                            <a href="{{ route('home') }}" class="btn btn-outline-primary float-end m-2">
                                Main site
                                <i class="bi bi-arrow-right"></i>
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
