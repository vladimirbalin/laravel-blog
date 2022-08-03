@php
    $isPost = !empty($post);
    $item = $isPost ? $post : $category;
@endphp

@if($item->exists)
    <div class="card my-2">
        <div class="card-body">
            <p>
                ID: <strong>{{$item->id}}</strong>
            </p>
        </div>
        @if($item->user_id)
            <div class="card-body">
                <p>
                    Author: <strong>{{$item->user->name}}</strong>
                </p>
            </div>
        @endif
        <div class="card-body">
            <p>
                Created at: <strong>{{$item->created_at}}</strong>
            </p>
        </div>
        <div class="card-body">
            <p>
                Updated at: <strong>{{$item->updated_at}}</strong>
            </p>
        </div>
        @if($isPost)
            <div class="card-body">
                <p>
                    Published at: <strong>{{$item->published_at}}</strong>
                </p>
            </div>
        @endif
        <div class="card-body">
            <p>
                Deleted at: <strong>{{$item->deleted_at}}</strong>
            </p>
        </div>
    </div>
    @if($isPost)
        <h3>Tags:</h3>
        @foreach($item->tags as $tag)
            <span class="badge text-bg-light">{{ $tag->title }}</span>
        @endforeach
    @endif
@endif
