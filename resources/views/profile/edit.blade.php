@extends('layouts.app')

@section('title', 'Mon Profil - NoteBox')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow animate-fadeInUp">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i>Mon Profil
                    </h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-placeholder mb-3">
                            <span class="display-4">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <h3>{{ Auth::user()->name }}</h3>
                        <p class="text-muted">{{ Auth::user()->email }}</p>
                        <p class="text-muted small">Membre depuis {{ Auth::user()->created_at->format('d/m/Y') }}</p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            <div class="stat-card p-3 rounded bg-light mb-3">
                                <i class="bi bi-journal-text text-primary fs-3"></i>
                                <h5 class="mt-2">{{ Auth::user()->notes->count() }}</h5>
                                <p class="text-muted mb-0">Notes</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="stat-card p-3 rounded bg-light mb-3">
                                <i class="bi bi-tags text-success fs-3"></i>
                                <h5 class="mt-2">{{ Auth::user()->categories->count() }}</h5>
                                <p class="text-muted mb-0">Catégories</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="stat-card p-3 rounded bg-light mb-3">
                                <i class="bi bi-star-fill text-warning fs-3"></i>
                                <h5 class="mt-2">{{ Auth::user()->notes->where('is_favorite', true)->count() }}</h5>
                                <p class="text-muted mb-0">Favoris</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Informations du profil</h5>
                        <form method="POST" action="{{ route('profile.update') }}" class="mt-3">
                            @csrf
                            @method('patch')

                            <div class="mb-3">
                                <label for="name" class="form-label">Nom</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>Mettre à jour le profil
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Changer le mot de passe</h5>
                        <form method="POST" action="{{ route('password.update') }}" class="mt-3">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Mot de passe actuel</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" name="current_password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Nouveau mot de passe</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-lock me-2"></i>Changer le mot de passe
                                </button>
                            </div>
                        </form>
                    </div>

                    <div>
                        <h5 class="border-bottom pb-2 text-danger">Supprimer le compte</h5>
                        <p class="text-muted">Une fois votre compte supprimé, toutes vos ressources et données seront définitivement effacées.</p>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            <i class="bi bi-trash me-2"></i>Supprimer mon compte
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression de compte -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible et toutes vos données seront perdues.</p>
                <form method="POST" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
                    @csrf
                    @method('delete')
                    <div class="mb-3">
                        <label for="delete_password" class="form-label">Veuillez entrer votre mot de passe pour confirmer</label>
                        <input type="password" class="form-control" id="delete_password" name="password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteAccountForm').submit()">
                    <i class="bi bi-trash me-1"></i>Supprimer définitivement
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .avatar-placeholder {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .stat-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush
@endsection
