@extends('layouts.app')
@section('content')
    <div class="container p-5">
        <h2 class="font-weight-bold mb-5">User Details</h2>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show my-4" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(auth()->user()->id == $profile->id)
            <a href="{{route('blog.profile.edit', $profile->id)}}" class="btn btn-success">Edit Profile</a>
        @endif

        <ul class="list-unstyled">
            <li><span>Name:</span> <b>{{ $profile->fullName }}</b></li>
            <li><span>Phone:</span> <b>{{ $profile->phone }}</b></li>
            <li><span>Email:</span> <b>{{ $profile->email }}</b></li>
        </ul>

        <h3>follows:</h3>
        <ul>
            @foreach($profile->followedUsers as $user)
                <li><a href="{{route('blog.profile.show', $user->id)}}">{{ $user->fullName }}</a></li>
            @endforeach
        </ul>

        <h3>followed by:</h3>
        <ul>
            @foreach($profile->followedByUsers as $user)
                <li><a href="{{route('blog.profile.show', $user->id)}}">{{ $user->fullName }}</a></li>
            @endforeach
        </ul>
    </div>
@endsection
