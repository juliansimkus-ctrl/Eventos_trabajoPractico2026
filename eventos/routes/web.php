<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CommentController;



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

// Historial de presupuestos del cliente logueado
Route::get('/mis-presupuestos', [BookingController::class, 'misPresupuestos'])->name('bookings.mine')->middleware('auth');

//rutas para crear formularios
Route::get('/admin/proyectos/crear', [ProjectController::class, 'create'])->name('admin.projects.create')->middleware(['auth', 'admin']);
Route::post('/admin/proyectos', [ProjectController::class, 'store'])->name('admin.projects.store')->middleware(['auth', 'admin']);

// Rutas para administrar, editar y eliminar proyectos
Route::get('/admin/proyectos', [ProjectController::class, 'adminIndex'])->name('admin.projects.index')->middleware(['auth', 'admin']);
Route::get('/admin/proyectos/{project}/editar', [ProjectController::class, 'edit'])->name('admin.projects.edit')->middleware(['auth', 'admin']);
Route::put('/admin/proyectos/{project}', [ProjectController::class, 'update'])->name('admin.projects.update')->middleware(['auth', 'admin']);
Route::delete('/admin/proyectos/{project}', [ProjectController::class, 'destroy'])->name('admin.projects.destroy')->middleware(['auth', 'admin']);

// comentarios 
Route::post('/porfolio/{project}/comentarios', [CommentController::class, 'store'])->name('comments.store');

// Gestión de Solicitudes de Presupuesto (Solo Admin)
Route::get('/admin/presupuestos', [BookingController::class, 'index'])->name('admin.bookings.index')->middleware(['auth', 'admin']);
Route::patch('/admin/presupuestos/{booking}/estado', [BookingController::class, 'updateStatus'])->name('admin.bookings.status')->middleware(['auth', 'admin']);

// Gestión de Servicios (Solo Admin)
Route::get('/admin/servicios', [ServiceController::class, 'index'])->name('admin.services.index')->middleware(['auth', 'admin']);
Route::post('/admin/servicios', [ServiceController::class, 'store'])->name('admin.services.store')->middleware(['auth', 'admin']);
Route::get('/admin/servicios/{service}/editar', [ServiceController::class, 'edit'])->name('admin.services.edit')->middleware(['auth', 'admin']);
Route::put('/admin/servicios/{service}', [ServiceController::class, 'update'])->name('admin.services.update')->middleware(['auth', 'admin']);
Route::delete('/admin/servicios/{service}', [ServiceController::class, 'destroy'])->name('admin.services.destroy')->middleware(['auth', 'admin']);