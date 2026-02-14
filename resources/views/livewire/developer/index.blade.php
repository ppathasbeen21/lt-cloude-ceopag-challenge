<div class="container mt-4">
    <div class="row mb-3">
        <div class="col-md-12">
            <h2>Desenvolvedores</h2>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" wire:model.live="search" class="form-control" placeholder="Buscar por nome ou email...">
        </div>
        <div class="col-md-4">
            <input type="text" wire:model.live="skillFilter" class="form-control" placeholder="Filtrar por skill...">
        </div>
        <div class="col-md-4">
            <select wire:model.live="seniorityFilter" class="form-control">
                <option value="">Todas as senioridades</option>
                <option value="Jr">Júnior</option>
                <option value="Pl">Pleno</option>
                <option value="Sr">Sênior</option>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <a href="{{ route('developers.create') }}" class="btn btn-primary">Novo Desenvolvedor</a>
        </div>
    </div>

    <div class="row">
        @foreach($developers as $developer)
            <div class="col-md-4 col-12 mb-3">
                <div class="card">
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
                        <a href="{{ route('developers.edit', $developer->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $developers->links() }}
</div>
