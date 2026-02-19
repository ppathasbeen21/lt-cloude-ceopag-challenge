<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>{{ $developerId ? 'Editar' : 'Novo' }} Desenvolvedor</h3>
        </div>
        <div class="card-body">
            <form wire:submit="save">
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Senioridade</label>
                    <select wire:model="seniority" class="form-control @error('seniority') is-invalid @enderror">
                        <option value="">Selecione...</option>
                        <option value="Jr">Júnior</option>
                        <option value="Pl">Pleno</option>
                        <option value="Sr">Sênior</option>
                    </select>
                    @error('seniority') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Skills</label>
                    <div class="input-group mb-2">
                        <input type="text" wire:model="skillInput" class="form-control" placeholder="Digite uma skill...">
                        <button type="button" wire:click="addSkill" class="btn btn-secondary">Adicionar</button>
                    </div>
                    <div>
                        @foreach($skills as $index => $skill)
                            <span class="badge bg-primary me-1">
                                {{ $skill }}
                                <button type="button" wire:click="removeSkill({{ $index }})" class="btn-close btn-close-white btn-sm"></button>
                            </span>
                        @endforeach
                    </div>
                    @error('skills') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="{{ route('developers.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
