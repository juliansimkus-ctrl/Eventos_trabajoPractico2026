<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**SECCION DE LOGIN */

    //muestra la vista para iniciar sesion
    public function showLogin()
    {
        return view('auth.login');
    }

    // guarda la sesion iniciada
    public function storeLogin(Request $request) 
    {
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

    }

    public function logout(Request $request) 
    {
        Auth::logout();
        
        $request->session()->invalidate();
        
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    /**SECCION DE REGISTRO */
    //muestra la vista para registrarse
    public function showRegister()
    {
        return view('auth.register');
    }
    
    //guarda el registro
    public function storeRegister(Request $request)
    {
        // 1. Validar
        $validated = $request->validate([
            'name'     => 'required|string|max:80',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
            'phone' => 'max:15|nullable',
            ]);
            
        // 2. Crear el usuario
        $user = User::create($validated);
        
        // 3. Dejarlo logueado
        Auth::login($user);
        $request->session()->regenerate();
        
        // 4. Redirigir
        return redirect()->route('porfolio.index');
        }
}
