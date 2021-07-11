@extends('layouts.app')

@section('content')
    <div class="container content">
        @include('web.blog.includes.session-msg')
        <a href="{{ route('blog.posts.create') }}" class="btn btn-primary m-3">Create post</a>
        @foreach($paginator as $post)
            @php /** @var \App\Models\BlogPost $post */ @endphp
            <div class="col-md-8 col-sm-12 mx-auto">
                <div class="card card-body ">
                    <a class="d-block" href="{{ route('blog.posts.show', $post->id) }}">
                        <h4 class="card-title">{{$post->title}}</h4>
                    </a>
                    <div class="bg-light p-2 mb-3 fs-6 text-dark posted-by">posted by: <span
                            class="font-weight-bold">{{ $post->getAuthor() }}</span> on {{ $post->whenPublished() }}
                    </div>
                    <div class="d-flex justify-content-lg-between">

                        <p class="card-text w-75">{{ $post->limitedContent() }}</p>
                        @if(!$post->isAuthor())
                            <div class="float-right">
                                <button title="Love it"
                                        class=
                                        "like likes-counter
                                        {{ $post->isLiked() ? 'active' : '' }}"
                                        data-count="{{ $post->likesCount() }}"
                                        data-route="{{ route('blog.posts.likePostAjax', $post->id) }}"
                                        data-id="{{ $post->id }}">
                                <span class="text-center">
                                    &#x2764;
                                </span>
                                </button>
                            </div>
                        @else
                           <div class="d-flex flex-column align-items-center">
                               <span class="text-danger">&#x2764: {{ $post->likesCount() }}</span>
                           </div>
                        @endif
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
