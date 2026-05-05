<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Routes protégées par authentification
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Notes routes
    Route::resource('notes', NoteController::class);
    Route::patch('/notes/{note}/favorite', [NoteController::class, 'toggleFavorite'])->name('notes.toggle-favorite');
    Route::get('/calendar', [NoteController::class, 'calendar'])->name('notes.calendar');
    
    // Categories routes
    Route::resource('categories', CategoryController::class)->except(['show', 'create', 'edit']);
});

// Routes d'administration
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
});

require __DIR__.'/auth.php';
