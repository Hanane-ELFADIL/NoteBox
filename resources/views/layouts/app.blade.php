<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'NoteBox'))</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand animate-fadeInLeft" href="{{ route('notes.index') }}">
                <i class="bi bi-journal-bookmark-fill me-2"></i>NoteBox
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('notes.index') ? 'active' : '' }}" href="{{ route('notes.index') }}">
                            <i class="bi bi-house-fill me-1"></i>Mes Notes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('notes.calendar') ? 'active' : '' }}" href="{{ route('notes.calendar') }}">
                            <i class="bi bi-calendar3 me-1"></i>Calendrier
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                            <i class="bi bi-tags-fill me-1"></i>Catégories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('notes.create') ? 'active' : '' }}" href="{{ route('notes.create') }}">
                            <i class="bi bi-plus-circle me-1"></i>Nouvelle Note
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <!-- Theme Toggle -->
                    <li class="nav-item">
                        <button class="btn btn-outline-light btn-sm me-2" id="theme-toggle">
                            <i class="bi bi-sun-fill" id="theme-icon"></i>
                        </button>
                    </li>
                    
                    <!-- User Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person-gear me-2"></i>Mon profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show animate-fadeInUp" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show animate-fadeInUp" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

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
                        <li><a href="{{ route('notes.index') }}">Prise de notes</a></li>
                        <li><a href="{{ route('categories.index') }}">Catégories</a></li>
                        <li><a href="{{ route('notes.calendar') }}">Calendrier</a></li>
                        <li><a href="{{ route('notes.index', ['filter' => 'favorites']) }}">Favoris</a></li>
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

            // Auto-hide alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
            
            // Add animation to elements with animate-* classes
            const animatedElements = document.querySelectorAll('[class*="animate-"]');
            animatedElements.forEach((element, index) => {
                element.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
