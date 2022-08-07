@extends('layouts.blank')

@section('content')
    <div class="container">
        <div class="min-vh-100 d-flex flex-row align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card-group d-block d-md-flex row">
                            <div class="card col-md-4 p-4 mb-0">
                                <div class="card-body">
                                    <x-session-message/>

                                    <form method="POST" action="{{ route('blog.register-post') }}">
                                        @csrf
                                        <h1>{{ __('Registration') }}</h1>
                                        <div class="input-group mb-3">
                                            <input id="name" type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   name="name"
                                                   value="{{ old('name') }}" placeholder="{{ __('Name') }}"
                                                   required autocomplete="name" autofocus>

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="input-group mb-3">
                                            <input id="email" type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   name="email"
                                                   value="{{ old('email') }}" placeholder="{{ __('E-Mail') }}"
                                                   required autocomplete="email" autofocus>

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="input-group mb-3">
                                            <input id="password" type="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   name="password"
                                                   required placeholder="{{ __('Password') }}"
                                                   autocomplete="current-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="input-group mb-4">
                                            <input id="password_confirmation" type="password"
                                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                                   name="password_confirmation"
                                                   required placeholder="{{ __('Confirm password') }}"
                                                   autocomplete="password_confirmation">

                                            @error('confirm-password')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="d-flex flex-row justify-content-between mb-3">
                                            <div class="align-self-end">
                                                <button class="btn btn-primary px-4"
                                                        type="submit">{{ __('Register') }}
                                                </button>
                                            </div>
                                        </div>
                                        <hr>

                                        <a class="btn btn-sm btn-outline-info px-4 float-end"
                                           href="{{ route('admin.blog.login') }}"
                                           type="button">
                                            {{ __('Admin panel') }}
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                        <a class="btn btn-sm btn-outline-info px-4 float-end"
                                           href="{{ route('blog.login') }}"
                                           type="button">
                                            {{ __('Back to login page') }}
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
