<div class="container mt-4">
    <div class="row mb-3">
        <div class="col-md-12">
            <h2>Meus Artigos</h2>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" wire:model="search" class="form-control" placeholder="Buscar por título do artigo...">
            <small>*Buscar por titulo</small>
        </div>
        <div class="col-md-4">
            <select wire:model="developerFilter" class="form-control">
                <option value="">Todos os desenvolvedores</option>
                @foreach($developers as $dev)
                    <option value="{{ $dev->id }}">{{ $dev->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button wire:click="applyFilters" class="btn btn-primary w-100">🔍 Procurar</button>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <a href="{{ route('articles.create') }}" class="btn btn-success">✏️ Novo Artigo</a>
        </div>
    </div>

    <div class="row">
        @foreach($articles as $article)
            <div class="col-md-4 col-12 mb-3">
                <div class="card h-100">
                    @if($article->cover_image)
                        <img src="{{ Storage::url($article->cover_image) }}" class="card-img-top" alt="{{ $article->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $article->title }}</h5>
                        <p class="card-text">
                            <span class="">
                                {{ $article->content }}
                            </span>
                            <span class="badge bg-primary">{{ $article->category->name }}</span>
                            <br>
                            <strong>Publicado:</strong> {{ $article->published_at?->format('d/m/Y') ?? 'Rascunho' }}<br>
                            <strong>Desenvolvedores:</strong>
                            @forelse($article->developers->take(3) as $dev)
                                <span class="badge bg-light text-dark border">{{ $dev->name }}</span>
                            @empty
                                <span class="text-muted fst-italic">Sem autor</span>
                            @endforelse
                        </p>
                        <div class="btn-group" role="group">
                            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <button wire:click="confirmDelete({{ $article->id }})"
                                    class="btn btn-sm btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">Deletar</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $articles->links() }}

    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja deletar este artigo?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" wire:click="delete" class="btn btn-danger">Deletar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        Livewire.on('close-modal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            if (modal) modal.hide();
            document.body.classList.remove('modal-open');
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        });
    </script>
</div>
