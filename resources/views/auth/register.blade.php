<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inscription - {{ config('app.name', 'NoteBox') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="auth-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="auth-card animate-fadeInUp">
                        <!-- Header -->
                        <div class="auth-header">
                            <div class="text-center">
                                <a href="{{ url('/') }}" class="text-white text-decoration-none">
                                    <i class="bi bi-journal-bookmark-fill fs-1 mb-3 d-block"></i>
                                    <h2 class="fw-bold">NoteBox</h2>
                                </a>
                                <p class="mb-0 opacity-75">Créez votre compte gratuit</p>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="auth-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <!-- Name -->
                                <div class="form-floating mb-3">
                                    <input id="name" type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name') }}" 
                                           required autofocus autocomplete="name"
                                           placeholder="Votre nom">
                                    <label for="name">
                                        <i class="bi bi-person me-2"></i>Nom complet
                                    </label>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Email Address -->
                                <div class="form-floating mb-3">
                                    <input id="email" type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}" 
                                           required autocomplete="username"
                                           placeholder="nom@exemple.com">
                                    <label for="email">
                                        <i class="bi bi-envelope me-2"></i>Adresse email
                                    </label>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="form-floating mb-3">
                                    <input id="password" type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           name="password" required autocomplete="new-password"
                                           placeholder="Mot de passe">
                                    <label for="password">
                                        <i class="bi bi-lock me-2"></i>Mot de passe
                                    </label>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-floating mb-4">
                                    <input id="password_confirmation" type="password" 
                                           class="form-control @error('password_confirmation') is-invalid @enderror" 
                                           name="password_confirmation" required autocomplete="new-password"
                                           placeholder="Confirmer le mot de passe">
                                    <label for="password_confirmation">
                                        <i class="bi bi-lock-fill me-2"></i>Confirmer le mot de passe
                                    </label>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Terms -->
                                <div class="form-check mb-4">
                                    <input id="terms" type="checkbox" class="form-check-input" required>
                                    <label class="form-check-label small" for="terms">
                                        J'accepte les <a href="#" class="text-decoration-none">conditions d'utilisation</a> 
                                        et la <a href="#" class="text-decoration-none">politique de confidentialité</a>
                                    </label>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-person-plus me-2"></i>Créer mon compte
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Footer -->
                        <div class="auth-footer">
                            <p class="mb-0">
                                Déjà un compte ? 
                                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">
                                    Se connecter
                                </a>
                            </p>
                        </div>
                    </div>

                    <!-- Back to Home -->
                    <div class="text-center mt-4">
                        <a href="{{ url('/') }}" class="text-white text-decoration-none">
                            <i class="bi bi-arrow-left me-2"></i>Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Password strength indicator
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                const strength = getPasswordStrength(password);
                
                // Remove existing strength indicators
                const existingIndicator = this.parentElement.querySelector('.password-strength');
                if (existingIndicator) {
                    existingIndicator.remove();
                }
                
                // Add new strength indicator
                if (password.length > 0) {
                    const indicator = document.createElement('div');
                    indicator.className = 'password-strength mt-1 small';
                    indicator.innerHTML = `Force du mot de passe: <span class="text-${strength.color}">${strength.text}</span>`;
                    this.parentElement.appendChild(indicator);
                }
            });
            
            // Password confirmation validation
            confirmPasswordInput.addEventListener('input', function() {
                const password = passwordInput.value;
                const confirmPassword = this.value;
                
                if (confirmPassword.length > 0) {
                    if (password === confirmPassword) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else {
                        this.classList.remove('is-valid');
                        this.classList.add('is-invalid');
                    }
                }
            });
            
            function getPasswordStrength(password) {
                let score = 0;
                
                if (password.length >= 8) score++;
                if (/[a-z]/.test(password)) score++;
                if (/[A-Z]/.test(password)) score++;
                if (/[0-9]/.test(password)) score++;
                if (/[^A-Za-z0-9]/.test(password)) score++;
                
                switch (score) {
                    case 0:
                    case 1:
                        return { text: 'Très faible', color: 'danger' };
                    case 2:
                        return { text: 'Faible', color: 'warning' };
                    case 3:
                        return { text: 'Moyenne', color: 'info' };
                    case 4:
                        return { text: 'Forte', color: 'success' };
                    case 5:
                        return { text: 'Très forte', color: 'success' };
                    default:
                        return { text: 'Faible', color: 'warning' };
                }
            }
        });
    </script>
</body>
</html>
