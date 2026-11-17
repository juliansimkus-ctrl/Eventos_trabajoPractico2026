<?php

<<<<<<< HEAD
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
=======
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route; 
>>>>>>> karym
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
<<<<<<< HEAD
Route::get('/contacto', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/contacto', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/contacto/{id}/presupuesto', [BookingController::class, 'pdf'])->name('bookings.pdf');

Route::post('/porfolio/{project}/comentarios', [CommentController::class, 'store'])->name('comments.store');



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
=======
Route::get('/contacto', [BookingController::class, 'create'])->name('bookings.create')->middleware('auth');
Route::post('/contacto', [BookingController::class, 'store'])->name('bookings.store')->middleware('auth');
Route::get('/contacto/{id}/presupuesto', [BookingController::class, 'pdf'])->name('bookings.pdf')->middleware('auth');
>>>>>>> karym


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