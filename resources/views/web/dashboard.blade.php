@extends('layouts.web')

@section('content')
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <x-session-message/>

                <div class="card">
                        <div class="card-header"><h2>Dashboard</h2></div>
                    <div class="top-wrapper row">
                        <div class="col-12 col-lg-6">
                            <div class="card flex-fill tabs-wrapper">

                                <input type="radio" name="tabs-1" id="tab-2-1" class="input" checked>
                                <input type="radio" name="tabs-1" id="tab-2-2" class="input">
                                <div class="card-header d-flex flex-row">
                                    <p>Most popular authors(by likes)</p>
                                    <div class="month-sort mx-2">
                                        <a class="text-black text-decoration-dotted"
                                           href="#">
                                            <label for="tab-2-1" class="tab tab-2-1">
                                                last month
                                            </label>
                                        </a>
                                    </div>
                                    <div class="year-sort mx-2">
                                        <a class="text-black text-decoration-dotted" href="#">
                                            <label for="tab-2-2" class="tab tab-2-2">
                                                last year
                                            </label>
                                        </a>
                                    </div>
                                </div>

                                <div class="tab-content tab-content-2-1 p-3">
                                    <table class="w-100">
                                        <thead>
                                        <tr style="background-color: #afc2e8">
                                            <th>#</th>
                                            <th>name</th>
                                            <th>likes earned</th>
                                        </tr>
                                        </thead>
                                        @foreach($topAuthorsLastMonth as $author)
                                            <tr class="position-relative">
                                                <td>{{$author->sequence_number}}</td>
                                                <td>
                                                    <a href="{{ route('blog.profile.show', $author->id) }}"
                                                       class="stretched-link stretched-link-dashboard text-decoration-none">
                                                        {{ $author->name }}
                                                    </a>
                                                </td>
                                                <td>{{ $author->likes_count }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="tab-content tab-content-2-2 p-3">
                                    <table class="w-100">
                                        <thead>
                                        <tr style="background-color: #afc2e8">
                                            <th>#</th>
                                            <th>name</th>
                                            <th>likes earned</th>
                                        </tr>
                                        </thead>
                                        @foreach($topAuthorsLastYear as $author)
                                            <tr class="position-relative">
                                                <td>{{ $author->sequence_number }}</td>
                                                <td>
                                                    <a href="{{ route('blog.profile.show', $author->id) }}"
                                                       class="stretched-link stretched-link-dashboard text-decoration-none">
                                                        {{ $author->name }}
                                                    </a>
                                                </td>
                                                <td>{{ $author->likes_count }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="card flex-fill tabs-wrapper">
                                <input type="radio" name="tabs-2" id="tab-1-1" class="input" checked>
                                <input type="radio" name="tabs-2" id="tab-1-2" class="input">
                                <div class="card-header d-flex flex-row">
                                    <p>Top 5 popular posts</p>
                                    <div class="month-sort mx-2">
                                        <a class="text-black text-decoration-dotted"
                                           href="#">
                                            <label for="tab-1-1" class="tab tab-1-1">
                                                last month
                                            </label>
                                        </a>
                                    </div>
                                    <div class="year-sort mx-2">
                                        <a class="text-black text-decoration-dotted" href="#">
                                            <label for="tab-1-2" class="tab tab-1-2">
                                                last year
                                            </label>
                                        </a>
                                    </div>
                                </div>


                                <div class="tab-content tab-content-1-1 p-3">
                                    <table class="w-100">
                                        <thead>
                                        <tr style="background-color: #afc2e8">
                                            <th>#</th>
                                            <th>title</th>
                                            <th>published at</th>
                                            <th>likes</th>
                                        </tr>
                                        </thead>
                                        @foreach($topPostsLastMonth as $post)
                                            <tr class="position-relative">
                                                <td>{{ $post->sequence_number }}</td>
                                                <td>
                                                    <a href="{{ route('blog.posts.show', $post->slug) }}"
                                                       class="stretched-link stretched-link-dashboard text-decoration-none">
                                                        {{ \Illuminate\Support\Str::limit($post->title, 15, '...') }}
                                                    </a>
                                                </td>
                                                <td>{{ \Illuminate\Support\Carbon::create($post->created_at)->toFormattedDateString() }}</td>
                                                <td>{{ $post->count }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="tab-content tab-content-1-2 p-3">
                                    <table class="w-100">
                                        <thead>
                                        <tr style="background-color: #afc2e8">
                                            <th>#</th>
                                            <th>title</th>
                                            <th>published at</th>
                                            <th>likes</th>
                                        </tr>
                                        </thead>
                                        @foreach($topPostsLastYear as $post)
                                            <tr class="position-relative">
                                                <td>{{ $post->sequence_number }}</td>
                                                <td>
                                                    <a href="{{ route('blog.posts.show', $post->slug) }}"
                                                       class="stretched-link stretched-link-dashboard text-decoration-none">
                                                        {{ \Illuminate\Support\Str::limit($post->title, 15, '...') }}
                                                    </a>
                                                </td>
                                                <td>{{ \Illuminate\Support\Carbon::create($post->created_at)->toFormattedDateString() }}</td>
                                                <td>{{ $post->count }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    <ul class="list-unstyled d-flex flex-row justify-content-between p-3">
                        <li class="me-2">Users registered:
                            <span class="fw-bold">{{ \App\Models\User::count() }}</span>
                        </li>
                        <li class="me-2">Posts:
                            <span class="fw-bold">
                                {{ \App\Models\BlogPost::all()
                                                    ->where('status', \App\Models\BlogPost::STATUS_PUBLISHED)
                                                    ->count()
                                }}
                            </span>
                        </li>
                        <li class="me-2">Comments:
                            <span class="fw-bold">
                                {{ \App\Models\BlogComment::all()
                                                    ->where('status', \App\Models\BlogComment::STATUS_PUBLISHED)
                                                    ->count()
                                }}
                            </span>
                        </li>
                        <li class="me-2">Likes:
                            <span class="fw-bold">
                                {{ \Illuminate\Support\Facades\DB::table('blog_likes')->count() }}
                            </span>
                        </li>
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
