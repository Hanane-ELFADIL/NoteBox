@extends('layouts.app')

@section('title', 'Catégories - NoteBox')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow animate-fadeInUp">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-tags-fill me-2"></i>Mes Catégories
                    </h4>
                </div>
                <div class="card-body">
                    @if($categories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Couleur</th>
                                        <th>Nom</th>
                                        <th>Notes</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $index => $category)
                                        <tr class="animate-fadeInUp" style="animation-delay: {{ 0.1 + $index * 0.05 }}s;">
                                            <td>
                                                <span class="category-color" style="background-color: {{ $category->color }};"></span>
                                            </td>
                                            <td>{{ $category->name }}</td>
                                            <td>
                                                <a href="{{ route('notes.index', ['category_id' => $category->id]) }}" class="text-decoration-none">
                                                    <span class="badge bg-secondary">{{ $category->notes_count }}</span>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-primary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editCategoryModal{{ $category->id }}">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deleteCategoryModal{{ $category->id }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        
                                        <!-- Modal d'édition -->
                                        <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title">Modifier la catégorie</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST" action="{{ route('categories.update', $category) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="name{{ $category->id }}" class="form-label">Nom</label>
                                                                <input type="text" class="form-control" id="name{{ $category->id }}" 
                                                                       name="name" value="{{ $category->name }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="color{{ $category->id }}" class="form-label">Couleur</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input type="color" class="form-control form-control-color me-2" 
                                                                           id="color{{ $category->id }}" name="color" 
                                                                           value="{{ $category->color }}" required>
                                                                    <div class="color-preview p-3 rounded" style="background-color: {{ $category->color }};"></div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <p class="mb-2">Aperçu :</p>
                                                                <div class="p-3 rounded border">
                                                                    <span class="badge rounded-pill p-2 preview-badge" style="background-color: {{ $category->color }};">
                                                                        <span class="preview-name">{{ $category->name }}</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Modal de suppression -->
                                        <div class="modal fade" id="deleteCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">Confirmer la suppression</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Êtes-vous sûr de vouloir supprimer la catégorie <strong>{{ $category->name }}</strong> ?</p>
                                                        @if($category->notes_count > 0)
                                                            <div class="alert alert-warning">
                                                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                                                Cette catégorie contient {{ $category->notes_count }} note(s). 
                                                                Les notes ne seront pas supprimées mais perdront leur catégorie.
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        <form method="POST" action="{{ route('categories.destroy', $category) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 animate-fadeInUp">
                            <i class="bi bi-tags display-1 text-muted mb-3"></i>
                            <p class="text-muted">Vous n'avez pas encore créé de catégories</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow animate-fadeInRight">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-plus-circle-fill me-2"></i>Nouvelle Catégorie
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('categories.store') }}" id="newCategoryForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom de la catégorie</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="color" class="form-label">Couleur</label>
                            <div class="d-flex align-items-center">
                                <input type="color" class="form-control form-control-color me-2 @error('color') is-invalid @enderror" 
                                       id="color" name="color" value="{{ old('color', '#007bff') }}" required>
                                <div class="color-preview p-3 rounded" id="colorPreview" style="background-color: {{ old('color', '#007bff') }};"></div>
                            </div>
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <p class="mb-2">Aperçu :</p>
                            <div class="p-3 rounded border">
                                <span class="badge rounded-pill p-2" id="previewBadge" style="background-color: {{ old('color', '#007bff') }};">
                                    <span id="previewName">{{ old('name', 'Nouvelle catégorie') }}</span>
                                </span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-plus-circle-fill me-2"></i>Créer la catégorie
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="card shadow mt-4 animate-fadeInRight" style="animation-delay: 0.2s;">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle-fill me-2"></i>Astuces
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="bi bi-palette-fill me-2 text-primary"></i>
                            Choisissez des couleurs distinctes pour faciliter l'identification
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-tag-fill me-2 text-success"></i>
                            Créez des catégories pour organiser vos notes par thème
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-filter-circle-fill me-2 text-warning"></i>
                            Utilisez les catégories pour filtrer vos notes sur la page d'accueil
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Preview for new category
        const nameInput = document.getElementById('name');
        const colorInput = document.getElementById('color');
        const colorPreview = document.getElementById('colorPreview');
        const previewBadge = document.getElementById('previewBadge');
        const previewName = document.getElementById('previewName');
        
        nameInput.addEventListener('input', function() {
            previewName.textContent = this.value || 'Nouvelle catégorie';
        });
        
        colorInput.addEventListener('input', function() {
            colorPreview.style.backgroundColor = this.value;
            previewBadge.style.backgroundColor = this.value;
        });
        
        // Preview for edit modals
        document.querySelectorAll('[id^="editCategoryModal"]').forEach(modal => {
            const modalId = modal.id;
            const categoryId = modalId.replace('editCategoryModal', '');
            
            const nameInput = document.getElementById('name' + categoryId);
            const colorInput = document.getElementById('color' + categoryId);
            const previewBadge = modal.querySelector('.preview-badge');
            const previewName = modal.querySelector('.preview-name');
            const colorPreview = modal.querySelector('.color-preview');
            
            if (nameInput && colorInput && previewBadge && previewName && colorPreview) {
                nameInput.addEventListener('input', function() {
                    previewName.textContent = this.value;
                });
                
                colorInput.addEventListener('input', function() {
                    previewBadge.style.backgroundColor = this.value;
                    colorPreview.style.backgroundColor = this.value;
                });
            }
        });
    });
</script>
@endpush
@endsection
