@extends('layouts.app')

@section('content')
    <div class="container">

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="mb-4">
            <h2>Olá, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-muted">Bem-vindo ao seu painel de controle.</p>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card text-white bg-primary h-100 shadow-sm">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">
                        <div style="font-size:2.5rem;">👩‍💻</div>
                        <h3 class="fw-bold my-1">{{ $devCount }}</h3>
                        <p class="mb-0 small">Desenvolvedores</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card text-white bg-success h-100 shadow-sm">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">
                        <div style="font-size:2.5rem;">📝</div>
                        <h3 class="fw-bold my-1">{{ $articleCount }}</h3>
                        <p class="mb-0 small">Artigos</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card text-white bg-info h-100 shadow-sm">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">
                        <div style="font-size:2.5rem;">✅</div>
                        <h3 class="fw-bold my-1">{{ $publishedCount }}</h3>
                        <p class="mb-0 small">Publicados</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card text-white bg-warning h-100 shadow-sm">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">
                        <div style="font-size:2.5rem;">📋</div>
                        <h3 class="fw-bold my-1">{{ $draftCount }}</h3>
                        <p class="mb-0 small">Rascunhos</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>📝 Últimos Artigos</strong>
                        <a href="{{ route('articles.index') }}" class="btn btn-sm btn-outline-primary">Ver todos</a>
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse($latestArticles as $article)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold">{{ Str::limit($article->title, 40) }}</div>
                                    <small class="text-muted">
                                        {{ $article->developers->count() }} dev(s) ·
                                        {{ $article->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                @if($article->published_at)
                                    <span class="badge bg-success">Publicado</span>
                                @else
                                    <span class="badge bg-warning text-dark">Rascunho</span>
                                @endif
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Nenhum artigo ainda.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>👩‍💻 Desenvolvedores Ativos</strong>
                        <a href="{{ route('developers.index') }}" class="btn btn-sm btn-outline-primary">Ver todos</a>
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse($topDevelopers as $developer)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold">{{ $developer->name }}</div>
                                    <small class="text-muted">{{ $developer->email }}</small>
                                </div>
                                <div class="d-flex gap-1 align-items-center">
                                    @php
                                        $color = match($developer->seniority) {
                                            'Sr' => 'bg-success', 'Pl' => 'bg-primary', default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $color }}">{{ $developer->seniority }}</span>
                                    <span
                                        class="badge bg-info text-dark">{{ $developer->articles_count }} artigos</span>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Nenhum desenvolvedor ainda.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-2">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body d-flex gap-3 flex-wrap">
                        <a href="{{ route('developers.create') }}" class="btn btn-primary">+ Novo Desenvolvedor</a>
                        <a href="{{ route('articles.create') }}" class="btn btn-success">+ Novo Artigo</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
