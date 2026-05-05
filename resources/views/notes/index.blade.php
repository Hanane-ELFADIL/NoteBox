@extends('layouts.app')

@section('title', 'Mes Notes - NoteBox')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="hero-section animate-fadeInUp">
        <div class="hero-content">
            <h1 class="hero-title">
                <i class="bi bi-journal-bookmark-fill me-3"></i>Mes Notes
            </h1>
            <p class="hero-subtitle">Organisez vos idées, gérez vos tâches et ne perdez jamais une pensée importante</p>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="row mb-4 animate-fadeInUp" style="animation-delay: 0.2s;">
        <div class="col-md-8">
            <form method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Rechercher dans vos notes..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('notes.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle-fill me-2"></i>Nouvelle Note
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4 animate-fadeInUp" style="animation-delay: 0.3s;">
        <div class="col-12">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('notes.index') }}" class="btn btn-sm {{ !request()->hasAny(['filter', 'category_id']) ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi bi-grid-fill me-1"></i>Toutes
                </a>
                <a href="{{ route('notes.index', ['filter' => 'favorites']) }}" class="btn btn-sm {{ request('filter') == 'favorites' ? 'btn-warning' : 'btn-outline-warning' }}">
                    <i class="bi bi-star-fill me-1"></i>Favoris
                </a>
                <a href="{{ route('notes.index', ['filter' => 'today']) }}" class="btn btn-sm {{ request('filter') == 'today' ? 'btn-success' : 'btn-outline-success' }}">
                    <i class="bi bi-calendar-day me-1"></i>Aujourd'hui
                </a>
                <a href="{{ route('notes.index', ['filter' => 'week']) }}" class="btn btn-sm {{ request('filter') == 'week' ? 'btn-info' : 'btn-outline-info' }}">
                    <i class="bi bi-calendar-week me-1"></i>Cette semaine
                </a>
                
                @foreach($categories as $category)
                    <a href="{{ route('notes.index', ['category_id' => $category->id]) }}" 
                       class="btn btn-sm {{ request('category_id') == $category->id ? 'btn-secondary' : 'btn-outline-secondary' }}">
                        <span class="badge rounded-pill me-1" style="background-color: {{ $category->color }};">&nbsp;</span>
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Notes Grid -->
    @if($notes->count() > 0)
        <div class="row">
            @foreach($notes as $index => $note)
                <div class="col-md-6 col-lg-4 mb-4 animate-fadeInUp" style="animation-delay: {{ 0.4 + $index * 0.1 }}s;">
                    <div class="card note-card h-100 shadow-sm position-relative">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0 text-truncate">{{ $note->title }}</h6>
                            <form method="POST" action="{{ route('notes.toggle-favorite', $note) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-link p-0 text-warning">
                                    <i class="bi {{ $note->is_favorite ? 'bi-star-fill' : 'bi-star' }}"></i>
                                </button>
                            </form>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-muted">{{ Str::limit($note->content, 100) }}</p>
                            
                            @if($note->category)
                                <span class="badge rounded-pill mb-2" style="background-color: {{ $note->category->color }};">
                                    {{ $note->category->name }}
                                </span>
                            @endif
                            
                            @if($note->reminder_date)
                                <div class="text-muted small">
                                    <i class="bi bi-alarm me-1"></i>{{ $note->reminder_date->format('d/m/Y H:i') }}
                                </div>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $note->created_at->diffForHumans() }}</small>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('notes.show', $note) }}" class="btn btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('notes.edit', $note) }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteNoteModal{{ $note->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteNoteModal{{ $note->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title">Confirmer la suppression</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Êtes-vous sûr de vouloir supprimer cette note ?</p>
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
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center animate-fadeInUp" style="animation-delay: 0.8s;">
            {{ $notes->links() }}
        </div>
    @else
        <div class="text-center py-5 animate-fadeInUp" style="animation-delay: 0.4s;">
            <i class="bi bi-journal-x display-1 text-muted mb-4"></i>
            <h4 class="text-muted">Aucune note trouvée</h4>
            <p class="text-muted">Commencez par créer votre première note !</p>
            <a href="{{ route('notes.create') }}" class="btn btn-primary animate-pulse">
                <i class="bi bi-plus-circle-fill me-2"></i>Créer ma première note
            </a>
        </div>
    @endif
</div>
@endsection
