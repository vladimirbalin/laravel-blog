@extends('layouts.app')
@section('content')
    <div class="container p-5">
        <h2 class="font-weight-bold mb-5">User Details</h2>
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show my-4" role="alert">
                @foreach($errors->all() as $error)
                    <span>{{$error}}</span><br>
                @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form action="{{route('blog.profile.update', $profile->id)}}" method="post">
            @csrf
            @method('PATCH')


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
