@extends('layouts.web')

@section('content')
    <div class="container content">
        <h2>Email verification simulation page</h2>
        <x-session-message/>

        @if(! auth()->user()->hasVerifiedEmail())
            <li class="list-group-item"><span>Verify Email</span>
                <b><a href="{{ url()->signedRoute('blog.confirm.email', ['user' => auth()->user()->id]) }}">
                        {{ url()->signedRoute('blog.confirm.email', ['user' => auth()->user()->id]) }}
                    </a></b>
            </li>
        @endif
    </div>
@endsection
