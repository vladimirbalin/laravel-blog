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

    <!-- Main styles for this application-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Global site tag (gtag.js) - Google Analytics-->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/coreui.bundle.js') }}" defer></script>

</head>
<body class="c-app">
<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">

    </div>
    <ul class="c-sidebar-nav">

        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('admin.home') }}">
                Dashboard
            </a>
        </li>
        <li class="c-sidebar-nav-title">Things</li>
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('admin.blog.categories.index') }}">
                Post categories</a></li>
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('admin.blog.posts.index') }}">
                Posts</a></li>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
            data-class="c-sidebar-minimized"></button>
</div>
<div class="c-wrapper c-fixed-components">
    <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
        <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar"
                data-class="c-sidebar-lg-show" responsive="true">
            <svg class="c-icon c-icon-lg">
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
        <ul class="c-header-nav ml-auto mr-4">

            <li class="c-header-nav-item dropdown">
                <a class="c-header-nav-link" data-toggle="dropdown" href="#"
                   role="button" aria-haspopup="true" aria-expanded="false">
                    <div>
                        {{ auth()->user()->name }}
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('admin.logout') }}"
                       onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        Logout</a>
                </div>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </header>
    <div class="c-body">
        <main>
            @yield('content')
        </main>
        <footer class="c-footer">
            <div><a href="https://coreui.io">CoreUI</a> &copy; 2020 creativeLabs.</div>
        </footer>
    </div>
</div>
</body>
</html>
