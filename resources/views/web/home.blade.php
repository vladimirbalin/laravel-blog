@extends('layouts.web')

@section('content')
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-session-message/>

                <div class="card">
                    <div class="card-header"><h2>Dashboard</h2></div>
                    <div class="top-wrapper d-flex flex-row">
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

                            <div class="tab-content tab-content-2-1">
                                <ul class="list-group list-group-flush">
                                    @foreach($topAuthorsLastMonth as $author)
                                        <li class="list-group-item">
                                            <a href="{{ route('blog.profile.show', $author->id) }}"
                                               class="stretched-link stretched-link-dashboard text-decoration-none">
                                                {{ $author->name }} |
                                                {{ $author->likes_count }} likes
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="tab-content tab-content-2-2">
                                <ul class="list-group list-group-flush">
                                    @foreach($topAuthorsLastYear as $author)
                                        <li class="list-group-item">
                                            <a href="{{ route('blog.profile.show', $author->id) }}"
                                               class="stretched-link stretched-link-dashboard text-decoration-none">
                                                {{ $author->name }} |
                                                {{ $author->likes_count }} likes
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
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


                            <div class="tab-content tab-content-1-1">
                                <ul class="list-group list-group-flush">
                                    @foreach($topPostsLastMonth as $post)
                                        <li class="list-group-item">
                                            <a href="{{ route('blog.posts.show', $post->id) }}"
                                               class="stretched-link stretched-link-dashboard text-decoration-none">
                                                {{ \Illuminate\Support\Str::limit($post->title, 10, '...') }}
                                                | {{ \Illuminate\Support\Carbon::create($post->created_at)->toFormattedDateString() }}
                                                | {{ $post->count }} likes
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="tab-content tab-content-1-2">
                                <ul class="list-group list-group-flush">
                                    @foreach($topPostsLastYear as $post)
                                        <li class="list-group-item">
                                            <a href="{{ route('blog.posts.show', $post->id) }}"
                                               class="stretched-link stretched-link-dashboard text-decoration-none">
                                                {{ \Illuminate\Support\Str::limit($post->title, 10, '...') }}
                                                | {{ \Illuminate\Support\Carbon::create($post->created_at)->toFormattedDateString() }}
                                                | {{ $post->count }} likes
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
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
                                                    ->where('is_published', \App\Models\BlogPost::STATUS_PUBLISHED)
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
