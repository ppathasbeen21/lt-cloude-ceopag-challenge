@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 h-100 overflow-hidden">
        <div class="row g-0" style="height: 100%;">
            <div class="col-md-6 order-2 order-md-1" style="min-height: 300px;">
                <picture class="d-block">
                    <img src="{{ asset('images/login-bg.png') }}"
                         alt="DevLog CeoPag"
                         class="w-100 vh-100"
                         style="object-fit: cover; object-position: center;">
                </picture>
            </div>
            <div class="col-md-6 order-1 order-md-2 d-flex align-items-center justify-content-center bg-body">
                <div class="w-100 px-4 py-5" style="max-width: 420px;">

                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logoceopag.png') }}" height="48" alt="Logo CeoPag" class="mb-3">
                        <h1 class="fs-4 fw-semibold mb-1">Faça login na sua conta</h1>
                        <p class="text-muted small">Insira suas credenciais para acessar o portal.</p>
                    </div>

                    @error('email')
                    <div class="alert alert-danger py-2 small">{{ $message }}</div>
                    @enderror

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-floating mb-3">
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}"
                                   placeholder="E-mail" required autocomplete="email" autofocus>
                            <label for="email">E-mail</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" placeholder="Senha"
                                   required autocomplete="current-password">
                            <label for="password">Senha</label>
                            @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label small" for="remember">Lembrar-me</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="small text-decoration-none">Esqueceu sua senha?</a>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-medium">
                            Entrar
                        </button>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-secondary w-100 py-2 mt-2">
                                Criar conta
                            </a>
                        @endif
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
