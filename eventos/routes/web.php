<?php

use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BookingController;

Route::redirect('/', '/porfolio');

// Rutas del Portafolio
Route::get('/porfolio', [ProjectController::class, 'index'])->name('porfolio.index');
Route::get('/porfolio/{slug}', [ProjectController::class, 'show'])->name('porfolio.show');

// Rutas del Formulario de Cotizacion
Route::get('/contacto', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/contacto', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/contacto/{booking}/presupuesto', [BookingController::class, 'pdf'])->name('bookings.pdf');