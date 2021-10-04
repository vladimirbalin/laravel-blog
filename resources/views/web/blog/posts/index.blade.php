@extends('layouts.app')
@section('content')
    <div class="container content">
        @include('web.blog.includes.session-msg')
        <a href="{{ route('blog.posts.create') }}" class="btn btn-primary m-3">Create post</a>
        <a href="{{ route('blog.posts.index', ['sort' => 'likesCount', 'page' => request('page')]) }}"
           class="btn btn-sm btn-info m-3">sort by likes asc</a>
        <a href="{{ route('blog.posts.index', ['sort' => '-likesCount', 'page' => request('page')]) }}"
           class="btn btn-sm btn-info m-3">sort by likes desc</a>
        @foreach($paginator as $post)
            @php /** @var \App\Models\BlogPost $post */ @endphp
            <div class="col-md-8 col-sm-12 mx-auto">
                <div class="card card-body">
                    <div class="top d-flex justify-content-between w-100">
                        <div class="left w-100">
                            <a class="d-block" href="{{ route('blog.posts.show', $post->id) }}">
                                <h4 class="card-title">{{$post->title}}</h4>
                            </a>
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
{{--                {!! $paginator->appends(\Request::except('page'))->render() !!}][1]--}}

            </div>
        @endif
    </div>
@endsection
