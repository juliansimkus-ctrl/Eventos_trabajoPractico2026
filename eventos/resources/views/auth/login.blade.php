@extends('layouts.eventos')

@section('title', 'Iniciar Sesión - Simkus Eventos')

@section('content')
<div class="min-h-[70vh] flex flex-col justify-center items-center px-4">
    <div class="max-w-md w-full bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-stone-100">
        
        <!-- Cabecera del Formulario -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-serif font-bold text-stone-900 tracking-tight">Panel de Control</h1>
            <p class="text-stone-500 text-sm mt-2 font-light">Ingresá tus credenciales para gestionar el porfolio y los presupuestos.</p>
        </div>

        <!-- Alerta de Errores Globales de Validación -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-6 text-xs leading-relaxed">
                @foreach ($errors->all() as $error)
                    <p class="font-medium">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Formulario de Autenticación -->
        <form action="{{ route('login.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Campo: Correo Electrónico -->
            <div>
                <label for="email" class="block text-sm font-semibold text-stone-700 mb-1">Correo electrónico</label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="ejemplo@simkus.com"
                    class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition" 
                    required 
                    autofocus
                >
                @error('email') 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Campo: Contraseña -->
            <div>
                <label for="password" class="block text-sm font-semibold text-stone-700 mb-1">Contraseña</label>
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    placeholder="••••••••"
                    class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition" 
                    required
                >
                @error('password') 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Botón de Envío -->
            <div class="pt-2">
                <button 
                    type="submit" 
                    class="w-full bg-stone-900 text-white font-semibold py-3 px-6 rounded-xl hover:bg-stone-800 shadow-sm transition transform active:scale-[0.98]"
                >
                    Ingresar al Panel
                </button>
            </div>
        </form>

    </div>

    <!-- Enlace de retorno estético por debajo del contenedor -->
    <div class="text-center mt-6">
        <a href="/porfolio" class="text-sm text-stone-400 hover:text-amber-700 transition flex items-center justify-center space-x-1">
            <span>&larr;</span> <span>Volver a la galería pública</span>
        </a>
    </div>
</div>
@endsection