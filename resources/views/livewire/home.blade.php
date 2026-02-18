<div class="container mt-4">

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">📝 Artigos Recentes</h4>
                <a href="{{ route('articles.index') }}" class="btn btn-sm btn-outline-primary">Ver todos</a>
            </div>

            @forelse($articles as $article)
                <div class="card shadow-sm mb-3">
                    <div class="row g-0">
                        @if($article->cover_image)
                            <div class="col-md-3">
                                <img src="{{ Storage::url($article->cover_image) }}"
                                     class="img-fluid rounded-start h-100"
                                     style="object-fit:cover; max-height:140px; width:100%;"
                                     alt="Capa">
                            </div>
                            <div class="col-md-9">
                                @else
                                    <div class="col-12">
                                        @endif
                                        <div class="card-body py-2 px-3">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <h6 class="card-title fw-bold mb-1">{{ $article->title }}</h6>
                                                @if($article->published_at)
                                                    <span class="badge bg-success ms-2 text-nowrap">Publicado</span>
                                                @endif
                                            </div>

                                            <div class="mb-1">
                                                @if($article->category)
                                                    <span
                                                        class="badge bg-secondary">{{ $article->category->name }}</span>
                                                @endif
                                                <small
                                                    class="text-muted ms-1">{{ $article->published_at?->format('d/m/Y') }}</small>
                                            </div>

                                            <div class="text-muted small">
                                                <strong>Autores:</strong>
                                                @forelse($article->developers->take(3) as $dev)
                                                    <span
                                                        class="badge bg-light text-dark border">{{ $dev->name }}</span>
                                                @empty
                                                    <span class="text-muted fst-italic">Sem autor</span>
                                                @endforelse
                                                @if($article->developers->count() > 3)
                                                    <span
                                                        class="text-muted">+{{ $article->developers->count() - 3 }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                            </div>
                    </div>
                    @empty
                        <div class="alert alert-info">Nenhum artigo publicado ainda.</div>
                    @endforelse
                </div>
                <div class="col-md-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="fw-bold mb-0">👩‍💻 Desenvolvedores</h4>
                        <a href="{{ route('developers.index') }}" class="btn btn-sm btn-outline-primary">Ver todos</a>
                    </div>

                    <div class="card shadow-sm">
                        <ul class="list-group list-group-flush">
                            @forelse($developers as $developer)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-3 py-2">
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
                                <li class="list-group-item text-muted fst-italic">Nenhum desenvolvedor ainda.</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="mt-3 d-grid gap-2">
                        <a href="{{ route('articles.create') }}" class="btn btn-success">✏️ Novo Artigo</a>
                        <a href="{{ route('developers.create') }}" class="btn btn-primary">➕ Novo Dev</a>
                    </div>
                </div>

        </div>
    </div>
