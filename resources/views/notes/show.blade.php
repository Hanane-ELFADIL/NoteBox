@extends('layouts.app')

@section('title', $note->title . ' - NoteBox')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow animate-fadeInUp">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $note->title }}</h4>
                    <div>
                        <form method="POST" action="{{ route('notes.toggle-favorite', $note) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn {{ $note->is_favorite ? 'btn-warning' : 'btn-outline-warning' }}">
                                <i class="bi {{ $note->is_favorite ? 'bi-star-fill' : 'bi-star' }} me-1"></i>
                                {{ $note->is_favorite ? 'Retirer des favoris' : 'Ajouter aux favoris' }}
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        @if($note->category)
                            <span class="badge rounded-pill mb-3 p-2" style="background-color: {{ $note->category->color }};">
                                <i class="bi bi-tag-fill me-1"></i>{{ $note->category->name }}
                            </span>
                        @endif
                        
                        @if($note->reminder_date)
                            <div class="alert alert-info d-flex align-items-center">
                                <i class="bi bi-alarm me-2 fs-4"></i>
                                <div>
                                    <strong>Rappel programmé</strong><br>
                                    {{ $note->reminder_date->format('d/m/Y à H:i') }}
                                    @if($note->reminder_date->isFuture())
                                        <span class="badge bg-success ms-2">À venir</span>
                                    @else
                                        <span class="badge bg-secondary ms-2">Passé</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                        
                        <div class="note-content p-4 bg-light rounded border animate-fadeInUp" style="animation-delay: 0.2s;">
                            {!! nl2br(e($note->content)) !!}
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted small">
                            <div><i class="bi bi-calendar-date me-1"></i>Créée le {{ $note->created_at->format('d/m/Y à H:i') }}</div>
                            @if($note->updated_at->gt($note->created_at))
                                <div><i class="bi bi-pencil me-1"></i>Modifiée le {{ $note->updated_at->format('d/m/Y à H:i') }}</div>
                            @endif
                        </div>
                        
                        <div class="btn-group">
                            <a href="{{ route('notes.edit', $note) }}" class="btn btn-primary">
                                <i class="bi bi-pencil-square me-1"></i>Modifier
                            </a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteNoteModal">
                                <i class="bi bi-trash me-1"></i>Supprimer
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('notes.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Retour à la liste
                    </a>
                </div>
            </div>
            
            <!-- Related Notes -->
            @if($note->category && $note->category->notes->where('id', '!=', $note->id)->count() > 0)
                <div class="card mt-4 shadow-sm animate-fadeInUp" style="animation-delay: 0.3s;">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="bi bi-link-45deg me-2"></i>Notes similaires
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach($note->category->notes->where('id', '!=', $note->id)->take(3) as $relatedNote)
                                <a href="{{ route('notes.show', $relatedNote) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $relatedNote->title }}</h6>
                                        <small>{{ $relatedNote->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1 text-truncate">{{ Str::limit($relatedNote->content, 80) }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteNoteModal" tabindex="-1" aria-labelledby="deleteNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteNoteModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cette note ? Cette action est irréversible.</p>
                <p class="fw-bold">{{ $note->title }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form method="POST" action="{{ route('notes.destroy', $note) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Supprimer définitivement
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
