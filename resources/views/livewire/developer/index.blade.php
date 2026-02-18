<div class="container mt-4">
    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Desenvolvedores</h2>
        <a href="{{ route('developers.create') }}" class="btn btn-primary">+ Novo Desenvolvedor</a>
    </div>

    <div class="row mb-4 g-2">
        <div class="col-md-5">
            <input type="text" wire:model.live="search" class="form-control" placeholder="Buscar por nome ou email...">
        </div>
        <div class="col-md-4">
            <input type="text" wire:model.live="skillFilter" class="form-control"
                   placeholder="Filtrar por skill (ex: Laravel)...">
        </div>
        <div class="col-md-3">
            <select wire:model.live="seniorityFilter" class="form-select">
                <option value="">Todas as senioridades</option>
                <option value="Jr">Júnior</option>
                <option value="Pl">Pleno</option>
                <option value="Sr">Sênior</option>
            </select>
        </div>
    </div>
    <div class="row">
        @forelse($developers as $developer)
            <div class="col-md-4 col-12 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">{{ $developer->name }}</h5>
                            @php
                                $badgeColor = match($developer->seniority) {
                                    'Sr' => 'bg-success',
                                    'Pl' => 'bg-primary',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $badgeColor }}">{{ $developer->seniority }}</span>
                        </div>

                        <p class="text-muted small mb-2">{{ $developer->email }}</p>

                        <div class="mb-2">
                            @foreach($developer->skills as $skill)
                                <span class="badge bg-light text-dark border me-1 mb-1">{{ $skill }}</span>
                            @endforeach
                        </div>

                        <div class="mt-auto d-flex justify-content-between align-items-center pt-2 border-top">
                            <span>
                                <span class="text-muted small">Artigos:</span>
                                <span class="badge bg-info text-dark">{{ $developer->articles->count() }}</span>
                            </span>
                            <div class="d-flex gap-2">
                                <a href="{{ route('developers.edit', $developer->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <button wire:click="confirmDelete({{ $developer->id }})"
                                        class="btn btn-sm btn-danger">Excluir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Nenhum desenvolvedor encontrado. <a
                        href="{{ route('developers.create') }}">Cadastre o primeiro!</a></div>
            </div>
        @endforelse
    </div>

    {{ $developers->links() }}

    @if($deleteId)
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,0.5)">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar exclusão</h5>
                    </div>
                    <div class="modal-body">
                        Tem certeza que deseja excluir este desenvolvedor? Os vínculos com artigos também serão
                        removidos.
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
