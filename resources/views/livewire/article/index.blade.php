<div class="container mt-4">

    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Artigos</h2>
        <a href="{{ route('articles.create') }}" class="btn btn-primary">+ Novo Artigo</a>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <input type="text" wire:model.live="search" class="form-control" placeholder="Buscar por título ou slug...">
        </div>
    </div>

    <div class="row">
        @forelse($articles as $article)
            <div class="col-md-4 col-12 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($article->cover_image)
                        <img src="{{ Storage::url($article->cover_image) }}"
                             class="card-img-top"
                             style="height:180px; object-fit:cover;"
                             alt="Capa">
                    @else
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                             style="height:180px;">
                            <span class="fs-4">📄</span>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $article->title }}</h5>

                        <div class="mb-2">
                            @if($article->category)
                                <span class="badge bg-secondary">{{ $article->category->name }}</span>
                            @endif
                            @if($article->published_at)
                                <span class="badge bg-success">
                                    {{ $article->published_at->format('d/m/Y') }}
                                </span>
                            @else
                                <span class="badge bg-warning text-dark">Rascunho</span>
                            @endif
                        </div>

                        <p class="text-muted small mb-2">
                            <strong>Devs:</strong>
                            <span class="badge bg-info text-dark">{{ $article->developers->count() }}</span>
                            @foreach($article->developers->take(3) as $dev)
                                <span class="badge bg-light text-dark border">{{ $dev->name }}</span>
                            @endforeach
                            @if($article->developers->count() > 3)
                                <span class="text-muted">+{{ $article->developers->count() - 3 }}</span>
                            @endif
                        </p>

                        <div class="mt-auto d-flex gap-2">
                            <a href="{{ route('articles.edit', $article->id) }}"
                               class="btn btn-sm btn-warning">Editar</a>
                            <button wire:click="confirmDelete({{ $article->id }})"
                                    class="btn btn-sm btn-danger">Excluir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Nenhum artigo encontrado. <a href="{{ route('articles.create') }}">Crie o
                        primeiro!</a></div>
            </div>
        @endforelse
    </div>

    {{ $articles->links() }}

    @if($deleteId)
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,0.5)">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar exclusão</h5>
                    </div>
                    <div class="modal-body">
                        Tem certeza que deseja excluir este artigo? Esta ação não pode ser desfeita.
                    </div>
                    <div class="modal-footer">
                        <button wire:click="$set('deleteId', null)" class="btn btn-secondary">Cancelar</button>
                        <button wire:click="delete" class="btn btn-danger">Sim, excluir</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
