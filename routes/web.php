<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home'); 
})->name('home');

Route::get('/contact', function () {
    return view('contact.index'); 
})->name('contact');

// 1. PRIMERO: La lista general de eventos
Route::get('/events', [EventController::class, 'index'])->name('events.index');

// --- RUTAS PROTEGIDAS (Requieren Login) ---
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 2. SEGUNDO: Las rutas de CREAR evento (ANTES de la ruta 'show')
    // Estas rutas deben estar aquí dentro porque requieren estar logueado
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');

    // ... Rutas de perfil y carrito ...
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{event}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

// 3. TERCERO (Y ÚLTIMO): La ruta para ver un evento específico
// Esta debe ir AL FINAL para que no interfiera con 'create'
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

require __DIR__.'/auth.php';