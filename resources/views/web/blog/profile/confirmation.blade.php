@extends('layouts.app')

@section('content')
    <div class="container m-3">
        <h2>Testing purposes page</h2>
        @include('web.blog.includes.session-msg')
        @if(! auth()->user()->hasVerifiedEmail())
            <li class="list-group-item"><span>Verify Email</span>
                <b><a href="{{ url()->signedRoute('blog.confirm.email', ['user' => auth()->user()->id]) }}">
                        {{ url()->signedRoute('blog.confirm.email', ['user' => auth()->user()->id]) }}
                    </a></b>
            </li>
        @endif
    </div>
@endsection
