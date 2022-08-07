@push('head-scripts')
    <script src="{{ asset('js/includes/test-credentials.js') }}" defer></script>
@endpush

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

                                    <form method="POST" action="{{ route('blog.login-post') }}">
                                        @csrf
                                        <h1>{{ __('Login page') }}</h1>
                                        <p class="text-medium-emphasis">Sign In to your account</p>
                                        <div class="input-group mb-3">
                                            <input id="email" type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   name="email"
                                                   value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}"
                                                   required autocomplete="email" autofocus>

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="input-group mb-4">
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
                                        <div class="input-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                       id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row justify-content-between mb-3">
                                            <div class="align-self-end">
                                                <button class="btn btn-primary px-4"
                                                        type="submit">{{ __('Login') }}
                                                </button>
                                            </div>
                                            <div>
                                                <p>Fill the form with test credentials:</p>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="button" class="btn btn-danger text-white btn-credentials-1">
                                                        Admin user
                                                    </button>
                                                    <button type="button" class="btn btn-danger text-white btn-credentials-2">
                                                        Regular user
                                                    </button>
                                                </div>
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
                                           href="{{ route('blog.register') }}"
                                           type="button">
                                            {{ __('Register') }}
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
