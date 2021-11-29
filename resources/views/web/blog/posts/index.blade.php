@extends('layouts.app')
@section('content')
    <div class="container content">
        @include('web.blog.includes.session-msg')
        <a href="{{ route('blog.posts.create') }}" class="btn btn-primary m-3">Create post</a>

        <div class="col-md-8 col-sm-12 m-2 d-flex justify-content-between align-items-center mx-auto">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle"
                        type="button"
                        id="dropdownMenuButton"
                        data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    @php echo request()->get('category') ?? "Categories" @endphp
                </button>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @foreach($categoryDropdown as $category)
                        <a class="dropdown-item
                            @if($category->slug === request()->get('category')) active @endif"
                           href="{{ route('blog.posts.index',
                                            \Arr::collapse([request()->query(),
                                            ['category' => $category->slug]]))
                                }}">
                            {{ $category->title }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="btn-group" role="group">
                <a href="{{ route('blog.posts.index', \Arr::collapse(
                                                    [request()->query(),
                                                    ['sort' => 'likesCount']]
                                                )) }}"
                   class="btn btn-sm btn-info">likes &#8593;</a>
                <a href="{{ route('blog.posts.index',\Arr::collapse(
                                                    [request()->query(),
                                                    ['sort' => '-likesCount']]
                                                )) }}"
                   class="btn btn-sm btn-info">likes &#8595;</a>
            </div>
        </div>

        {{--  blog posts--}}
        @foreach($paginator as $post)
            @php /** @var \App\Models\BlogPost $post */ @endphp
            <div class="col-md-8 col-sm-12 mx-auto">
                <div class="card card-body">
                    <div class="top d-flex justify-content-between w-100">
                        <div class="left w-100">
                            <a class="d-block" href="{{ route('blog.posts.show', $post->id) }}">
                                <h4 class="card-title">{{ $post->id }}. {{$post->title}}</h4>
                            </a>
                            <p class="text-muted ml-2">{{ $post->category->title }}</p>
                        </div>
                        <div class="right w-100">
                            <div class="bg-light p-2 mb-3 fs-6 text-dark"><span
                                    class="font-weight-bold">by
                                    <a href="{{route('blog.profile.show', $post->user->id)}}">
                                        {{ $post->getAuthorName() }}
                                    </a>

                                    @php
                                        $isNotFollow = Auth::user()->isNotFollow($post->user->id);
                                        $isFollow = Auth::user()->isFollow($post->user->id);
                                    @endphp

                                    @if(!$post->isAuthor() && $isNotFollow)
                                        @include('web.blog.posts._follow-btn')
                                    @elseif(!$post->isAuthor() && $isFollow)
                                        @include('web.blog.posts._unfollow-btn')
                                    @endif
                        </span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-lg-between">
                        <div class="left d-flex flex-column">
                            <p class="card-text w-75">{{ $post->limitedContent() }}</p>
                            <div class="bottom  posted-by font-weight-bold text-dark">
                                {{ $post->whenPublished() }}
                            </div>
                        </div>
                        <div class="right">
                            @if(!$post->isAuthor())
                                <div class="float-right">
                                    <button title="Love it"
                                            class=
                                            "like likes-counter
                                        {{ $post->isLiked() ? 'active' : '' }}"
                                            data-count="{{ $post->likesCount }}"
                                            data-route="{{ route('blog.posts.like', $post->id) }}"
                                            data-id="{{ $post->id }}">
                                <span class="text-center">
                                    &#x2764;
                                </span>
                                    </button>
                                </div>
                            @else
                                <div class="float-right">
                                    <button title="Love it"
                                            disabled
                                            class=
                                            "like likes-counter disabled"
                                            data-count="{{ $post->likesCount }}"
                                            data-route="{{ route('blog.posts.like', $post->id) }}"
                                            data-id="{{ $post->id }}">
                                <span class="text-center">
                                    &#x2764;
                                </span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
        @php /** @var \Illuminate\Pagination\Paginator $paginator */ @endphp
        @if($paginator->total() > $paginator->count())
            <div class="row justify-content-center">
                {{ $paginator }}
            </div>
        @endif
    </div>
@endsection
