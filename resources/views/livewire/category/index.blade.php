<div class="container mt-4">

    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🏷️ Categorias</h2>
        <button wire:click="$toggle('showForm')" class="btn btn-primary">
            {{ $showForm ? '✕ Fechar' : '+ Nova Categoria' }}
        </button>
    </div>

    @if($showForm)
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">Nova Categoria</h5>
                <form wire:submit="save">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Nome <span class="text-danger">*</span></label>
                            <input type="text" wire:model="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Ex: Desenvolvimento, DevOps...">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success w-100">
                                <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1"></span>
                                Salvar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="card shadow-sm">
        <table class="table table-hover mb-0">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Slug</th>
                <th class="text-center">Artigos</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($categories as $category)
                <tr>
                    <td class="align-middle">
                        @if($editId === $category->id)
                            <input type="text" wire:model="editName"
                                   class="form-control form-control-sm @error('editName') is-invalid @enderror">
                            @error('editName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @else
                            <span class="fw-semibold">{{ $category->name }}</span>
                        @endif
                    </td>
                    <td class="align-middle text-muted small">{{ $category->slug }}</td>
                    <td class="align-middle text-center">
                        <span class="badge bg-info text-dark">{{ $category->articles_count }}</span>
                    </td>
                    <td class="align-middle text-end">
                        @if($editId === $category->id)
                            <button wire:click="update" class="btn btn-sm btn-success me-1">Salvar</button>
                            <button wire:click="cancelEdit" class="btn btn-sm btn-secondary">Cancelar</button>
                        @else
                            <button wire:click="startEdit({{ $category->id }})" class="btn btn-sm btn-warning me-1">Editar</button>
                            <button wire:click="confirmDelete({{ $category->id }})" class="btn btn-sm btn-danger">Excluir</button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-muted text-center py-4">Nenhuma categoria cadastrada.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if($deleteId)
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,0.5)">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar exclusão</h5>
                    </div>
                    <div class="modal-body">
                        Tem certeza? Os artigos vinculados a esta categoria podem ser afetados.
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
