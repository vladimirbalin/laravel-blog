@php /** @var \App\Models\BlogPost $post */ @endphp

<div class="card-group d-flex w-100">
    <div class="card card-bigger">
        <div class="card-body">
            <a class="d-block text-decoration-none stretched-link stretched-link-post-card"
               href="{{ route('blog.posts.show', $post->slug) }}">
                <h5 class="card-title">{{ $post->id }}. {{$post->title}}</h5>
            </a>
            <p class="card-text"><small>{{ $post->category->title }}</small></p>
            <p class="card-text">{{ $post->limitedContent(200) }}</p>
        </div>
        <div class="card-footer font-weight-bold text-dark">
            Published: {{ $post->whenPublished() }}
        </div>
    </div>
    <div class="card card-smaller">
        <div class="card-body">
            <div class="d-flex flex-column">
                                <span class="">by
                                    <a class="text-decoration-none"
                                       href="{{route('blog.profile.show', $post->user->id)}}">
                                    {{ $post->getAuthorName() }}
                                    </a>
                                </span>

                @php
                    $isNotFollow = Auth::user()->isNotFollow($post->user->id);
                    $isFollow = Auth::user()->isFollow($post->user->id);
                @endphp

                @if(!$post->isAuthor() && $isNotFollow)
{{--                    @include('web.blog.posts._follow-btn')--}}
                    <x-buttons.follow route-name="blog.profile.follow" :user-id="$post->user->id" />
                @elseif(!$post->isAuthor() && $isFollow)
{{--                    @include('web.blog.posts._unfollow-btn')--}}
                    <x-buttons.unfollow route-name="blog.profile.unfollow" :user-id="$post->user->id" />
                @endif
            </div>
        </div>
        <div class="card-footer bg-white">
            @if(!$post->isAuthor())
                <div class="heart-wrapper">
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
                <div class="heart-wrapper">
                    <button title="Love it"
                            disabled
                            class="like likes-counter disabled"
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
