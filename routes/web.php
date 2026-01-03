<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController; // <--- Importante: Añadido para que funcionen los pagos
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home'); 
})->name('home');

// Rutas de Contacto
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// 1. PRIMERO: La lista general de eventos
Route::get('/events', [EventController::class, 'index'])->name('events.index');

// --- RUTAS PROTEGIDAS (Requieren Login) ---
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 2. SEGUNDO: Las rutas de CREAR evento (ANTES de la ruta 'show')
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');

    // Perfil de Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Carrito de Compras
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{event}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    
    // --- RUTAS DE PAGO (Stripe Integrado) ---
    // 1. Mostrar la pantalla de pago (GET)
    Route::get('/checkout', [PaymentController::class, 'showPaymentForm'])->name('payment.checkout');
    
    // 2. Procesar el éxito (GET, retorno de Stripe)
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    
});

// 3. TERCERO (Y ÚLTIMO): La ruta para ver un evento específico
// Esta debe ir AL FINAL para que no interfiera con 'create' u otras palabras clave
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

require __DIR__.'/auth.php';