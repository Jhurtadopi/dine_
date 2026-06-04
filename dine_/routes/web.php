<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\GuestMenuController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => auth()->check() ? redirect()->route('dashboard') : redirect()->route('login'));

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Menú digital del comensal. Esta URL es la que queda codificada en el QR de cada mesa.
Route::prefix('mesa/{qrToken}')->name('guest.')->group(function () {
    Route::get('/menu', [GuestMenuController::class, 'index'])->name('menu');
    Route::post('/carrito/{dish}', [GuestMenuController::class, 'addToCart'])->name('cart.add');
    Route::patch('/carrito/{dish}', [GuestMenuController::class, 'updateCart'])->name('cart.update');
    Route::delete('/carrito/{dish}', [GuestMenuController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/finalizar', [GuestMenuController::class, 'finishSession'])->name('finish');
});

/*
|--------------------------------------------------------------------------
| Rutas autenticadas
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Mapa visual de mesas: administrador y mesero lo pueden consultar.
    Route::get('/mesas/estado-json', [TableController::class, 'statusFeed'])
        ->middleware('role:Administrator,Waiter')
        ->name('tables.statusFeed');

    Route::resource('tables', TableController::class)
        ->only(['index', 'show'])
        ->middleware('role:Administrator,Waiter');

    // Gestión de mesas: solo administrador.
    Route::resource('tables', TableController::class)
        ->except(['index', 'show'])
        ->middleware('role:Administrator');

    // Gestión del menú digital: solo administrador.
    Route::resource('categories', CategoryController::class)
        ->except(['show'])
        ->middleware('role:Administrator');

    Route::resource('dishes', DishController::class)
        ->middleware('role:Administrator');

    Route::patch('/dishes/{dish}/toggle-availability', [DishController::class, 'toggleAvailability'])
        ->middleware('role:Administrator')
        ->name('dishes.toggleAvailability');
});
