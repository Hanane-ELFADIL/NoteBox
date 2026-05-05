<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'NoteBox') }} - Organisez vos idées</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand animate-fadeInLeft" href="{{ url('/') }}">
                <i class="bi bi-journal-bookmark-fill me-2"></i>NoteBox
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <button class="btn btn-outline-light btn-sm me-3" id="theme-toggle">
                            <i class="bi bi-sun-fill" id="theme-icon"></i>
                        </button>
                    </li>
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ route('notes.index') }}" class="nav-link">
                                    <i class="bi bi-speedometer2 me-1"></i>Dashboard
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Connexion
                                </a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn btn-outline-light ms-2">
                                        <i class="bi bi-person-plus me-1"></i>Inscription
                                    </a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="welcome-hero" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('images/img1.jpg') }}') center/cover;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="welcome-content animate-fadeInUp">
                        <h1 class="welcome-title">
                            Bienvenue dans <span style="color: var(--primary-color);">NoteBox</span>
                        </h1>
                        <p class="welcome-subtitle">
                            L'application ultime pour organiser vos idées, gérer vos tâches et ne jamais perdre une pensée importante.
                        </p>
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            @auth
                                <a href="{{ route('notes.index') }}" class="btn btn-primary btn-lg animate-pulse">
                                    <i class="bi bi-rocket-takeoff me-2"></i>Accéder à mes notes
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="btn btn-primary btn-lg animate-pulse">
                                    <i class="bi bi-rocket-takeoff me-2"></i>Commencer gratuitement
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="display-5 fw-bold text-white mb-3 animate-fadeInUp">
                        Pourquoi choisir NoteBox ?
                    </h2>
                    <p class="lead text-white-50 animate-fadeInUp">
                        Découvrez les fonctionnalités qui font de NoteBox l'outil parfait pour votre productivité
                    </p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card animate-fadeInLeft">
                        <div class="feature-icon">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <h4 class="text-white mb-3">Rapide et Intuitif</h4>
                        <p class="text-white-50">
                            Interface moderne et intuitive pour créer, organiser et retrouver vos notes en quelques clics.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card animate-fadeInUp">
                        <div class="feature-icon">
                            <i class="bi bi-tags-fill"></i>
                        </div>
                        <h4 class="text-white mb-3">Organisation Parfaite</h4>
                        <p class="text-white-50">
                            Catégorisez vos notes avec des couleurs personnalisées et retrouvez-les facilement grâce à la recherche avancée.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card animate-fadeInRight">
                        <div class="feature-icon">
                            <i class="bi bi-alarm-fill"></i>
                        </div>
                        <h4 class="text-white mb-3">Rappels Intelligents</h4>
                        <p class="text-white-50">
                            Ne manquez plus jamais une échéance avec notre système de rappels et notre calendrier intégré.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card animate-fadeInLeft">
                        <div class="feature-icon">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h4 class="text-white mb-3">Favoris</h4>
                        <p class="text-white-50">
                            Marquez vos notes importantes comme favoris pour un accès rapide et une meilleure organisation.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card animate-fadeInUp">
                        <div class="feature-icon">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>
                        <h4 class="text-white mb-3">Calendrier Intégré</h4>
                        <p class="text-white-50">
                            Visualisez vos notes et rappels dans un calendrier interactif pour une meilleure planification.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card animate-fadeInRight">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check-fill"></i>
                        </div>
                        <h4 class="text-white mb-3">Sécurisé</h4>
                        <p class="text-white-50">
                            Vos données sont protégées avec un système d'authentification sécurisé et un accès personnel.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="card border-0 shadow-lg animate-fadeInUp">
                        <div class="card-body p-5">
                            <h3 class="display-6 fw-bold mb-3" style="color: var(--primary-color);">
                                Prêt à organiser votre vie ?
                            </h3>
                            <p class="lead text-muted mb-4">
                                Rejoignez des milliers d'utilisateurs qui ont déjà transformé leur façon de prendre des notes.
                            </p>
                            @guest
                                <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-3">
                                    <i class="bi bi-person-plus me-2"></i>Créer un compte gratuit
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                                </a>
                            @else
                                <a href="{{ route('notes.index') }}" class="btn btn-primary btn-lg">
                                    <i class="bi bi-journal-text me-2"></i>Accéder à mes notes
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h5><i class="bi bi-journal-bookmark-fill me-2"></i>NoteBox</h5>
                    <p class="text-white-50">
                        L'application de prise de notes qui transforme votre façon d'organiser vos idées et de gérer vos tâches quotidiennes.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white-50 fs-4"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white-50 fs-4"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-white-50 fs-4"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white-50 fs-4"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h5>Fonctionnalités</h5>
                    <ul>
                        <li><a href="#">Prise de notes</a></li>
                        <li><a href="#">Catégories</a></li>
                        <li><a href="#">Rappels</a></li>
                        <li><a href="#">Calendrier</a></li>
                        <li><a href="#">Favoris</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h5>Support</h5>
                    <ul>
                        <li><a href="#">Centre d'aide</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Tutoriels</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h5>Légal</h5>
                    <ul>
                        <li><a href="#">Conditions d'utilisation</a></li>
                        <li><a href="#">Politique de confidentialité</a></li>
                        <li><a href="#">Mentions légales</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} NoteBox. Tous droits réservés. Développé avec ❤️ pour votre productivité.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Theme toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('theme-toggle');
            const themeIcon = document.getElementById('theme-icon');
            const html = document.documentElement;

            // Get saved theme or default to light
            const savedTheme = localStorage.getItem('theme') || 'light';
            html.setAttribute('data-bs-theme', savedTheme);
            updateThemeIcon(savedTheme);

            themeToggle.addEventListener('click', function() {
                const currentTheme = html.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';

                html.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                updateThemeIcon(newTheme);
            });

            function updateThemeIcon(theme) {
                if (theme === 'dark') {
                    themeIcon.className = 'bi bi-moon-fill';
                } else {
                    themeIcon.className = 'bi bi-sun-fill';
                }
            }

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add animation delays
            const animatedElements = document.querySelectorAll('.animate-fadeInUp, .animate-fadeInLeft, .animate-fadeInRight');
            animatedElements.forEach((element, index) => {
                element.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>
