@extends('layouts.app')
@section('scripts')
    <script type="module">
        import Echo from '{{asset('js/echo.js')}}'
        import {Pusher} from '{{asset('js/pusher.js')}}'

        window.Pusher = Pusher
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: 'e68857e8510d7a58b561',
            cluster: 'eu',
            forceTLS: true
        });
        window.Echo.private('notifications')
            .listen('BlogPostPublished', (e) => {
                // this.messages.push({
                //     message: e.message.message,
                //     user: e.user
                // });
                alert(e);
                console.log(e);
            });
    </script>
@endsection
@section('content')
    <div class="container content">
        @include('web.blog.includes.session-msg')
        <a href="{{ route('blog.posts.create') }}" class="btn btn-primary m-3">Create post</a>
        @foreach($paginator as $post)
            @php /** @var \App\Models\BlogPost $post */ @endphp
            <div class="col-md-8 col-sm-12 mx-auto">
                <div class="card card-body">
{{--                    <script type="module">--}}
{{--                        window.Echo.private(`likes.{{$post->id}}`)--}}
{{--                            .listen('BlogPostLiked', (e) => {--}}
{{--                                alert(`Your post '${e?.post?.title}' was liked by '${e?.user?.name}'! Now it has ${e?.likesCount} likes!`);--}}
{{--                            });--}}
{{--                    </script>--}}
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
                                        $isNotFollows = Auth::user()->isNotFollows($post->user->id);
                                        $isFollows = Auth::user()->isFollows($post->user->id);
                                    @endphp

                                    @if(!$post->isAuthor() && $isNotFollows)
                                        <form action="{{ route('blog.posts.follow', $post->user->id) }}" method="post">
                                            @method('put')
                                            @csrf
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-primary follow">follow</button>
                                        </form>
                                    @elseif(!$post->isAuthor() && $isFollows)
                                        <form action="{{ route('blog.posts.unfollow', $post->user->id) }}"
                                              method="post">
                                            @method('put')
                                            @csrf
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-primary follow">unfollow</button>
                                        </form>
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
                                            data-route="{{ route('blog.posts.likePostAjax', $post->id) }}"
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
                                            data-route="{{ route('blog.posts.likePostAjax', $post->id) }}"
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
