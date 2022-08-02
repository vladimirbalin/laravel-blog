@extends('layouts.web')
@section('content')
    <div class="container p-5">
        <x-session-message/>

        <form action="{{route('blog.profile.update', $profile->id)}}" method="post">
            @csrf
            @method('PATCH')

            <div class="card mx-auto col-4">
                <div class="card-body">
                    <h2 class="card-title">User Details</h2>
                    <ul class="list-unstyled">
                        <li><span>Name: </span>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', $profile->fullName) }}">
                        </li>
                        <li><span>Phone: </span>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone', $profile->phone) }}">
                        </li>
                        <li><span>Email: </span>
                            <input type="text" name="email" class="form-control"
                                   value="{{ old('email', $profile->email) }}">
                        </li>
                    </ul>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>

    </div>
@endsection
