@extends('layouts.app')
@section('content')
    <div class="container p-5">
        <h2 class="font-weight-bold mb-5">User Details</h2>
        <div class="main d-flex justify-content-center text-center">
            <div class="left w-50">
                @include('web.blog.includes.session-msg')

                <ul class="list-group m-2">
                    <li class="list-group-item"><span>Name:</span> <b>{{ $profile->fullName }}</b></li>
                    <li class="list-group-item"><span>Phone:</span> <b>{{ $profile->phone }}</b></li>
                    <li class="list-group-item"><span>Email:</span> <b>{{ $profile->email }}</b></li>
                </ul>

                @if(auth()->user()->id == $profile->id)
                    <a href="{{route('blog.profile.edit', $profile->id)}}" class="btn btn-dark">Edit Profile</a>
                @endif
            </div>
            <div class="right">
                <ul class="list-group m-2">
                    <li class="list-group-item-dark list-group-item">Follows:</li>
                    @foreach($profile->followedUsers as $user)
                        <li class="list-group-item">
                            <a href="{{route('blog.profile.show', $user->id)}}">{{ $user->fullName }}</a>
                            @if(auth()->user()->id == $profile->id)
                                <button type="submit"
                                        class="btn btn-sm btn-outline-primary follow"
                                        onclick="document.getElementById('unfollow-{{$user->id}}').submit()">
                                    unfollow
                                </button>
                                <form action="{{ route('blog.posts.unfollow', $user->id) }}"
                                      method="post"
                                      id="unfollow-{{$user->id}}">
                                    @method('put')
                                    @csrf
                                </form>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <ul class="list-group">
                    <li class="list-group-item-dark list-group-item">
                        Followed by
                    </li>
                    @foreach($profile->followedByUsers as $user)
                        <li class="list-group-item"><a
                                href="{{route('blog.profile.show', $user->id)}}">{{ $user->fullName }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>


    </div>
@endsection
