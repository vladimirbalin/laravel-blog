<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    @auth
        <script>
            window.Laravel = {};
            window.Laravel.userId = {{ auth()->user()->id }};
            window.Laravel.notificationsRoute = '{{ route('blog.notifications') }}';
        </script>
    @endauth

    @yield('scripts')
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<div class="min-vh-100 h-100" id="app">
    <nav class="sticky navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Left Side Of Navbar -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item flex-row">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : ''}}"
                           href="{{ url('/') }}">{{ __('Dashboard') }}
                        </a>
                    </li>
                    <li class="nav-item flex-row">
                        <a class="nav-link {{ request()->routeIs('blog.posts.index') ? 'active' : ''}}"
                           href="{{ route('blog.posts.index') }}">{{ __('Posts') }}</a>
                    </li>
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('blog.login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('blog.register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-coreui-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('images/no-notifications.png') }}" width="20px"
                                     alt="no-notifications icon">
                                <span id="quantity-sum" class="badge badge-danger"></span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationsMenu"
                                id="notificationsMenu">
                                <li class="dropdown-item text-center d-none">
                                    <a onclick="event.preventDefault();
                                                    document.getElementById('notifications.allread').submit();"
                                       class="all-read btn btn-sm btn-secondary">
                                        Mark all as read
                                    </a>
                                </li>
                                <li class="dropdown-header">No new notifications</li>
                                <span id="all-notifications"></span>
                            </ul>
                        </li>

                        <form id="notifications.allread" action="{{ route('blog.notifications.read') }}"
                              method="post">
                            @method('patch')
                            @csrf
                        </form>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"
                                   href="{{ route('blog.profile.show', auth()->user()->id) }}">
                                    {{ __('Profile') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('blog.logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('blog.logout') }}" method="POST"
                                      class="d-none">
                                    @csrf
                                    @method('delete')
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="main p-3 d-flex align-items-center">
        @yield('content')
    </main>
</div>
</body>
</html>
