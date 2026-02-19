<div class="container mt-4">
    <div class="row mb-3">
        <div class="col-md-12">
            <h2>Meus Desenvolvedores</h2>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mb-3">
        <div class="col-md-3">
            <input type="text" wire:model="search" class="form-control" placeholder="Buscar por nome ou email...">
        </div>
        <div class="col-md-3">
            <input type="text" wire:model="skillFilter" class="form-control" placeholder="Filtrar por skill...">
        </div>
        <div class="col-md-3">
            <select wire:model="seniorityFilter" class="form-control">
                <option value="">Todas as senioridades</option>
                <option value="Jr">Júnior</option>
                <option value="Pl">Pleno</option>
                <option value="Sr">Sênior</option>
            </select>
        </div>
        <div class="col-md-3">
            <button wire:click="applyFilters" class="btn btn-primary w-100">🔍 Procurar</button>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <a href="{{ route('developers.create') }}" class="btn btn-success">➕ Novo Desenvolvedor</a>
        </div>
    </div>

    <div class="row">
        @foreach($developers as $developer)
            <div class="col-md-4 col-12 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $developer->name }}</h5>
                        <p class="card-text">
                            <strong>Email:</strong> {{ $developer->email }}<br>
                            <strong>Senioridade:</strong> <span class="badge bg-primary">{{ $developer->seniority }}</span><br>
                            <strong>Skills:</strong>
                            @foreach($developer->skills as $skill)
                                <span class="badge bg-secondary">{{ $skill }}</span>
                            @endforeach
                            <br>
                            <strong>Artigos:</strong> <span class="badge bg-info">{{ $developer->articles->count() }}</span>
                        </p>
                        <div class="btn-group" role="group">
                            <a href="{{ route('developers.edit', $developer->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <button wire:click="confirmDelete({{ $developer->id }})"
                                    class="btn btn-sm btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">Deletar</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $developers->links() }}

    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja deletar este desenvolvedor?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" wire:click="delete" class="btn btn-danger" data-bs-dismiss="modal">Deletar</button>
                </div>
            </div>
        </div>
    </div>
</div>
