@extends('layouts.app')

@section('title', 'Créer une note - NoteBox')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow animate-fadeInUp">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-plus-circle-fill me-2"></i>Créer une nouvelle note
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('notes.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Titre de la note</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Contenu</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="8" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Catégorie</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" 
                                            id="category_id" name="category_id">
                                        <option value="">Aucune catégorie</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}
                                                data-color="{{ $category->color }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div id="categoryColorPreview" class="mt-2" style="display: none;">
                                        <span class="badge rounded-pill p-2" id="colorBadge">&nbsp;</span>
                                        <span id="categoryName"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reminder_date" class="form-label">Rappel (optionnel)</label>
                                    <input type="datetime-local" class="form-control @error('reminder_date') is-invalid @enderror" 
                                           id="reminder_date" name="reminder_date" value="{{ old('reminder_date') }}">
                                    @error('reminder_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="is_favorite" name="is_favorite" 
                                   {{ old('is_favorite') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_favorite">
                                <i class="bi bi-star-fill text-warning me-1"></i>Marquer comme favori
                            </label>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('notes.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle-fill me-2"></i>Créer la note
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-resize textarea
        const textarea = document.getElementById('content');
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Category color preview
        const categorySelect = document.getElementById('category_id');
        const categoryColorPreview = document.getElementById('categoryColorPreview');
        const colorBadge = document.getElementById('colorBadge');
        const categoryName = document.getElementById('categoryName');
        
        categorySelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (this.value) {
                const color = selectedOption.getAttribute('data-color');
                colorBadge.style.backgroundColor = color;
                categoryName.textContent = selectedOption.textContent.trim();
                categoryColorPreview.style.display = 'block';
            } else {
                categoryColorPreview.style.display = 'none';
            }
        });
        
        // Trigger change event to initialize preview
        categorySelect.dispatchEvent(new Event('change'));
        
        // Set minimum date for reminder
        const reminderDateInput = document.getElementById('reminder_date');
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        
        const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
        reminderDateInput.setAttribute('min', minDateTime);
    });
</script>
@endpush
@endsection
