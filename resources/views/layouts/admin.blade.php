<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        Admin panel
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.home') }}">
                Dashboard
            </a>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.blog.categories.index') }}">
                Post categories</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.blog.posts.index') }}">
                Posts</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.blog.comments.index') }}">
                Comments</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.blog.tags.index') }}">
                Tags</a></li>
    </ul>
    <button class="minimizer c-class-toggler" type="button" data-target="_parent"
            data-class="minimized"></button>
</div>
<div class="wrapper d-flex flex-column min-vh-100 h-100 bg-light">
    <header class="header header-sticky mb-4">
        <button class="header-toggler px-md-0 me-md-3" type="button"
                onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <svg class="icon icon-lg">
                <svg id="cil-menu" viewBox="0 0 512 512">
                    <rect width="352" height="32" x="80" y="96" fill="var(--ci-primary-color, currentColor)"
                          class="ci-primary"></rect>
                    <rect width="352" height="32" x="80" y="240" fill="var(--ci-primary-color, currentColor)"
                          class="ci-primary"></rect>
                    <rect width="352" height="32" x="80" y="384" fill="var(--ci-primary-color, currentColor)"
                          class="ci-primary"></rect>
                </svg>
            </svg>
        </button>
        <ul class="header-nav ms-3">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle py-0" data-coreui-toggle="dropdown" href="#" role="button"
                   aria-haspopup="true" aria-expanded="false">
                        {{ auth()->user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('admin.blog.logout') }}"
                       onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        Logout</a>
                </div>
                <form id="logout-form" action="{{ route('admin.blog.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </header>
    <main class="h-100">
        @yield('content')
    </main>
</div>
</body>
</html>
