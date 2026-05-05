<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - {{ config('app.name', 'NoteBox') }}</title>
    
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
                                <p class="mb-0 opacity-75">Connectez-vous à votre compte</p>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="auth-body">
                            <!-- Session Status -->
                            @if (session('status'))
                                <div class="alert alert-success mb-4" role="alert">
                                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <!-- Email Address -->
                                <div class="form-floating mb-3">
                                    <input id="email" type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}" 
                                           required autofocus autocomplete="username"
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
                                           name="password" required autocomplete="current-password"
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

                                <!-- Remember Me -->
                                <div class="form-check mb-4">
                                    <input id="remember_me" type="checkbox" 
                                           class="form-check-input" name="remember">
                                    <label class="form-check-label" for="remember_me">
                                        Se souvenir de moi
                                    </label>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                                    </button>
                                </div>

                                <!-- Forgot Password -->
                                @if (Route::has('password.request'))
                                    <div class="text-center">
                                        <a href="{{ route('password.request') }}" class="text-decoration-none">
                                            <i class="bi bi-question-circle me-1"></i>Mot de passe oublié ?
                                        </a>
                                    </div>
                                @endif
                            </form>
                        </div>

                        <!-- Footer -->
                        <div class="auth-footer">
                            <p class="mb-0">
                                Pas encore de compte ? 
                                <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">
                                    Créer un compte
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
            // Focus effect on form inputs
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });

            // Button hover effect
            const submitBtn = document.querySelector('button[type="submit"]');
            submitBtn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            submitBtn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>
