<?php

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
Route::get('/contacto', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/contacto', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/contacto/{id}/presupuesto', [BookingController::class, 'pdf'])->name('bookings.pdf');

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// ----------------------------------------------------
// RUTAS DE AUTENTICACIÓN (Login manual con Modelo User)
// ----------------------------------------------------
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended(route('porfolio.index'));
    }

    return back()->withErrors([
        'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
    ])->onlyInput('email');
})->name('login.store');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');


// ----------------------------------------------------
// RUTAS DE ADMINISTRACIÓN (Protegidas)
// ----------------------------------------------------
Route::middleware('auth')->group(function () {
    // Formulario para subir nuevas ambientaciones con datos y fotos
    Route::get('/admin/proyectos/crear', [ProjectController::class, 'create'])->name('admin.projects.create');
    Route::post('/admin/proyectos', [ProjectController::class, 'store'])->name('admin.projects.store');
});