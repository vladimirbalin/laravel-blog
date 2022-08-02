@extends('layouts.web')
@section('content')
    <div class="container content align-self-start">
        <div class="col-md-8 col-sm-12 mx-auto">
            <x-session-message/>
        </div>
        <div class="col-md-8 col-sm-12 mx-auto">
            <a href="{{ route('blog.posts.create') }}" class="btn btn-primary m-3">
                <i class="bi bi-plus-square"></i>
            </a>
        </div>

        <div class="col-md-8 col-sm-12 m-2 d-flex justify-content-between align-items-center mx-auto">
            {{--sort buttons--}}
            <div class="sort-buttons-wrapper d-flex flex-row">
                <p>Sort by:</p>
                {{--likes sort--}}
                <div class="likes-sort mx-2">
                    @switch(request()->get('sort'))
                        @case('likes-count')
                            <x-sort-link baseRouteName="blog.posts.index"
                                         sortBy="-likes-count">
                                Popularity &#8593;
                            </x-sort-link>
                            @break
                        @case('-likes-count')
                            <x-sort-link baseRouteName="blog.posts.index"
                                         sortBy="likes-count">
                                Popularity &#8595;
                            </x-sort-link>
                            @break
                        @default
                            <x-sort-link baseRouteName="blog.posts.index"
                                         sortBy="-likes-count">
                                Popularity
                            </x-sort-link>
                    @endswitch
                </div>
                {{--date-sort--}}
                <div class="dates-sort mx-2">
                    @switch(request()->get('sort'))
                        @case('published_at')
                            <x-sort-link baseRouteName="blog.posts.index"
                                         sortBy="-published_at">
                                Published at &#8593; (oldest)
                            </x-sort-link>
                            @break
                        @case('-published_at')
                            <x-sort-link baseRouteName="blog.posts.index"
                                         sortBy="published_at">
                                Published at &#8595; (newest)
                            </x-sort-link>
                            @break
                        @default
                            <x-sort-link baseRouteName="blog.posts.index"
                                         sortBy="-published_at">
                                Published at
                            </x-sort-link>
                    @endswitch
                </div>
            </div>
            <x-category-dropdown :categoryDropdown="$categoryDropdown"/>
        </div>

        {{--  blog posts--}}
        @unless($paginator->count())
            <div class="text-center fs-2">
                <strong>-- No posts --</strong>
            </div>
        @endunless

        @foreach($paginator as $post)
            <div class="col-md-8 col-sm-12 d-flex mx-auto mb-5">
                <x-blog-post :post="$post"/>
            </div>
        @endforeach

        @php /** @var \Illuminate\Pagination\Paginator $paginator */ @endphp
        @if($paginator->total() > $paginator->count())
            {{ $paginator }}
        @endif
    </div>
@endsection
