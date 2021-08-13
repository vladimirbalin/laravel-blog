@extends('layouts.app')
@section('content')
    <div class="p-5">
        <form action="{{route('blog.profile.update', $profile->id)}}" method="post">
            @csrf
            @method('PATCH')
            <div class="font-weight-bold mb-5">User Details</div>

            <ul class="list-unstyled">
                <li><span>Name: </span>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $profile->fullName) }}">
                </li>
                <li><span>Phone: </span>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $profile->phone) }}">
                </li>
                <li><span>Email: </span>
                    <input type="text" name="email" class="form-control" value="{{ old('email', $profile->email) }}">
                </li>
            </ul>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>

    </div>
@endsection
