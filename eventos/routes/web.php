<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BookingController;


Route::redirect('/', '/porfolio');

// Rutas del Portafolio
Route::get('/porfolio', [ProjectController::class, 'index'])->name('porfolio.index');
Route::get('/porfolio/{slug}', [ProjectController::class, 'show'])->name('porfolio.show');

//usando AJAX
Route::get('/api/proyectos', [ProjectController::class, 'filtrar'])->name('porfolio.filtrar');

// Rutas del Formulario de Cotizacion
Route::get('/contacto', [BookingController::class, 'create'])->name('bookings.create')->middleware('auth');
Route::post('/contacto', [BookingController::class, 'store'])->name('bookings.store')->middleware('auth');
Route::get('/contacto/{id}/presupuesto', [BookingController::class, 'pdf'])->name('bookings.pdf')->middleware('auth');


//rutas para loguearse y desloguearse
Route::get('/login', [AuthController::class, 'showLogin']) ->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'storeLogin'])->name('login.store')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

//rutas para registro
Route::get('/register', [AuthController::class, 'showRegister']) -> name('register.show')->middleware('guest');
Route::post('/register', [AuthController::class, 'storeRegister']) -> name('register.store')->middleware('guest');


//rutas para crear formularios
Route::get('/admin/proyectos/crear', [ProjectController::class, 'create'])->name('admin.projects.create')->middleware(['auth', 'admin']);
Route::post('/admin/proyectos', [ProjectController::class, 'store'])->name('admin.projects.store')->middleware(['auth', 'admin']);