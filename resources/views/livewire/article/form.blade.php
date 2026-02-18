<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">{{ $articleId ? 'Editar Artigo' : 'Novo Artigo' }}</h3>
            <a href="{{ route('articles.index') }}" class="btn btn-sm btn-secondary">← Voltar</a>
        </div>
        <div class="card-body">

            <form wire:submit="save" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Título <span class="text-danger">*</span></label>
                        <input type="text" wire:model.live="title"
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="Título do artigo">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Slug <span class="text-danger">*</span></label>
                        <input type="text" wire:model="slug"
                               class="form-control @error('slug') is-invalid @enderror"
                               placeholder="gerado-automaticamente">
                        @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Categoria <span class="text-danger">*</span></label>
                        <select wire:model="category_id" class="form-select @error('category_id') is-invalid @enderror">
                            <option value="">Selecione uma categoria...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Data de Publicação</label>
                        <input type="datetime-local" wire:model="published_at"
                               class="form-control @error('published_at') is-invalid @enderror">
                        <div class="form-text">Deixe vazio para salvar como rascunho.</div>
                        @error('published_at')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Conteúdo <span class="text-danger">*</span></label>
                    <textarea id="article-content"
                              wire:model="content"
                              class="form-control @error('content') is-invalid @enderror"
                              rows="10"
                              placeholder="Escreva o conteúdo do artigo..."></textarea>
                    @error('content')
                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Imagem de Capa</label>

                    @if($existingCover)
                        <div class="mb-2 d-flex align-items-center gap-3">
                            <img src="{{ Storage::url($existingCover) }}"
                                 alt="Capa atual"
                                 class="img-thumbnail"
                                 style="max-height:120px;">
                            <button type="button" wire:click="removeCover" class="btn btn-sm btn-danger">
                                Remover capa
                            </button>
                        </div>
                    @endif

                    <input type="file" wire:model="cover_image"
                           class="form-control @error('cover_image') is-invalid @enderror"
                           accept="image/*">
                    <div class="form-text">Opcional. Máx 2MB. Formatos: jpg, png, gif, webp.</div>
                    @error('cover_image')
                    <div class="invalid-feedback">{{ $message }}</div> @enderror

                    @if($cover_image)
                        <div class="mt-2">
                            <strong>Preview:</strong><br>
                            <img src="{{ $cover_image->temporaryUrl() }}"
                                 class="img-thumbnail mt-1"
                                 style="max-height:120px;">
                        </div>
                    @endif
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Desenvolvedores Vinculados</label>
                    @if($developers->isEmpty())
                        <div class="alert alert-warning py-2">
                            Nenhum desenvolvedor cadastrado ainda.
                            <a href="{{ route('developers.create') }}">Cadastre aqui</a>.
                        </div>
                    @else
                        <div class="row row-cols-2 row-cols-md-3 g-2">
                            @foreach($developers as $developer)
                                <div class="col">
                                    <div class="form-check border rounded p-2 h-100
                                        {{ in_array($developer->id, $selectedDevelopers) ? 'border-primary bg-primary bg-opacity-10' : '' }}">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               wire:model="selectedDevelopers"
                                               value="{{ $developer->id }}"
                                               id="dev-{{ $developer->id }}">
                                        <label class="form-check-label w-100 cursor-pointer"
                                               for="dev-{{ $developer->id }}">
                                            <strong>{{ $developer->name }}</strong><br>
                                            <span class="badge bg-secondary">{{ $developer->seniority }}</span>
                                            @foreach(array_slice($developer->skills, 0, 2) as $skill)
                                                <span class="badge bg-light text-dark border">{{ $skill }}</span>
                                            @endforeach
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('selectedDevelopers')
                        <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1"></span>
                        Salvar Artigo
                    </button>
                    <a href="{{ route('articles.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    function initTinyMCE() {
        tinymce.remove();
        tinymce.init({
            selector: '#article-content',
            plugins: 'lists link image code table',
            toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | code',
            height: 350,
            menubar: false,
            setup: function (editor) {
                // Sync de volta para o textarea/Livewire ao salvar
                editor.on('change', function () {
                    editor.save();
                    let el = document.getElementById('article-content');
                    el.dispatchEvent(new Event('input'));
                });
            }
        });
    }

    document.addEventListener('DOMContentLoaded', initTinyMCE);
    document.addEventListener('livewire:navigated', initTinyMCE);
</script>
