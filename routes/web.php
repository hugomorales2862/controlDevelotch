<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\TransaccionController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('clientes', ClienteController::class);
    Route::resource('servicios', ServicioController::class);
    Route::resource('pagos', PagoController::class);
    Route::resource('transacciones', TransaccionController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('documentos', DocumentoController::class);
    Route::resource('tickets', TicketController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
