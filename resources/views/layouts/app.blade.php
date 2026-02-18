<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light" id="html-root">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LT Cloud') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        [data-bs-theme="dark"] .navbar {
            background-color: #1e1e2d !important;
        }

        [data-bs-theme="dark"] .card {
            border-color: #333;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .btn-theme-toggle {
            border: none;
            background: transparent;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md shadow-sm"
         style="background-color: var(--bs-body-bg); border-bottom:1px solid var(--bs-border-color);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                🚀 {{ config('app.name', 'LT Cloud') }}
            </a>

            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('developers.*') ? 'active fw-bold' : '' }}"
                               href="{{ route('developers.index') }}">👩‍💻 Desenvolvedores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('articles.*') ? 'active fw-bold' : '' }}"
                               href="{{ route('articles.index') }}">📝 Artigos</a>
                        </li>
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <button class="btn-theme-toggle nav-link" id="theme-toggle" title="Alternar tema">
                            🌙
                        </button>
                    </li>

                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Registrar</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                👤 {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Sair
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <main class="py-4">
            @yield('content')
        </main>
    </main>
</div>

@livewireScripts

<script>
    // Dark / Light mode persistente via localStorage
    (function () {
        const saved = localStorage.getItem('theme') || 'light';
        document.getElementById('html-root').setAttribute('data-bs-theme', saved);
        updateToggleIcon(saved);

        function updateToggleIcon(theme) {
            const btn = document.getElementById('theme-toggle');
            if (btn) btn.textContent = theme === 'dark' ? '☀️' : '🌙';
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateToggleIcon(localStorage.getItem('theme') || 'light');
            document.getElementById('theme-toggle').addEventListener('click', function () {
                const current = document.getElementById('html-root').getAttribute('data-bs-theme');
                const next = current === 'dark' ? 'light' : 'dark';
                document.getElementById('html-root').setAttribute('data-bs-theme', next);
                localStorage.setItem('theme', next);
                updateToggleIcon(next);
            });
        });
    })();
</script>
</body>
</html>
