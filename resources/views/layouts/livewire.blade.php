<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light" id="html-root">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logoceopag.png') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DevLog CeoPag') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body { font-family: 'Nunito', sans-serif; }
        [data-bs-theme="dark"] .navbar { background-color: #1e1e2d !important; }
        [data-bs-theme="dark"] .card { border-color: #333; }
        [data-bs-theme="dark"] .dropdown-menu { background-color: #2a2a3d; border-color: #444; }
        [data-bs-theme="dark"] .dropdown-item { color: #ccc; }
        [data-bs-theme="dark"] .dropdown-item:hover { background-color: #3a3a5a; color: #fff; }
        .cursor-pointer { cursor: pointer; }
.btn-theme-toggle { border: none; background: transparent; font-size: 1.2rem; }
        .img-preview { max-height: 120px; }
        .img-article-thumb { max-height: 140px; }
        .modal-backdrop-custom { background: rgba(0,0,0,0.5); }
    </style>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md shadow-sm"
         class="navbar-light border-bottom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <img src="{{ asset('images/logoceopag.png') }}" width="20px" height="20px" alt="Logo Ceopag">
                <span class="lh-1">DevLog CeoPag</span>
            </a>

            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('articles.*') || request()->routeIs('categories.*') ? 'active fw-bold' : '' }}"
                               href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                📝 Artigos
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('articles.index') }}">📋 Listar Artigos</a></li>
                                <li><a class="dropdown-item" href="{{ route('articles.create') }}">✏️ Novo Artigo</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('categories.index') }}">🏷️ Categorias</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('developers.*') ? 'active fw-bold' : '' }}"
                               href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                👩‍💻 Desenvolvedores
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('developers.index') }}">📋 Listar Devs</a></li>
                                <li><a class="dropdown-item" href="{{ route('developers.create') }}">➕ Novo Dev</a></li>
                            </ul>
                        </li>
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <button class="btn-theme-toggle nav-link" id="theme-toggle" title="Alternar tema">🌙</button>
                    </li>
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrar</a></li>
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
        {{ $slot }}
    </main>
</div>

@livewireScripts

<script>
    (function () {
        const saved = localStorage.getItem('theme') || 'light';
        document.getElementById('html-root').setAttribute('data-bs-theme', saved);

        function updateToggleIcon(theme) {
            const btn = document.getElementById('theme-toggle');
            if (btn) btn.textContent = theme === 'dark' ? '☀️' : '🌙';
        }

        updateToggleIcon(saved);

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
