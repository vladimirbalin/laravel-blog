@extends('layouts.web')

@section('content')
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h2>Dashboard</h2></div>
                    <ul class="list-unstyled p-3">
                        <li>Total users registered: {{ \App\Models\User::count() }}</li>
                        <li>Total published blog posts:
                            {{ \App\Models\BlogPost::all()
                                                    ->where('is_published', \App\Models\BlogPost::STATUS_PUBLISHED)
                                                    ->count()
                            }}
                        </li>
                        <li>Total published comments:
                            {{ \App\Models\BlogComment::all()
                                                    ->where('status', \App\Models\BlogComment::STATUS_PUBLISHED)
                                                    ->count()
                            }}
                        </li>
                        <li>Total likes: {{ \Illuminate\Support\Facades\DB::table('blog_post_user')->count() }}</li>
                    </ul>
                </div>

                <a href="{{ route('blog.posts.index') }}" class="btn btn-danger text-white float-end m-2">
                    All posts <i class="bi bi-arrow-right"></i>
                </a>
                <a href="{{ route('admin.home') }}" class="btn btn-outline-info float-start m-2">
                    <i class="bi bi-arrow-left"></i>
                    Admin panel
                </a>
            </div>
        </div>
    </div>
@endsection
