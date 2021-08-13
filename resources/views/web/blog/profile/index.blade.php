@extends('layouts.app')
@section('content')
    <div class="p-5">
        <a href="{{route('blog.profile.edit', $profile->id)}}" class="btn btn-success">Edit Profile</a>
        <div class="font-weight-bold mb-5">User Details</div>

        <ul class="list-unstyled">
            <li><span>Name:</span> <b>{{ $profile->fullName }}</b></li>
            <li><span>Phone:</span> <b>{{ $profile->phone }}</b></li>
            <li><span>Email:</span> <b>{{ $profile->email }}</b></li>
        </ul>
    </div>
@endsection
