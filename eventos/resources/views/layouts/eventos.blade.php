<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Simkus Eventos - Decoración')</title>
    
    <!-- Carga de Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 text-stone-800 font-sans min-h-screen flex flex-col">

    <!-- Barra de Navegación -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
    <nav class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
        <div class="text-xl font-serif font-bold tracking-wide text-amber-700">
            <a href="/">Simkus Eventos</a>
        </div>
        
        <ul class="flex space-x-6 font-medium text-stone-600 items-center">
            <li><a href="/porfolio" class="hover:text-amber-700 transition">Porfolio</a></li>
            <li><a href="/contacto" class="hover:text-amber-700 transition">Contacto</a></li>
            
            {{-- SI EL USUARIO YA INICIÓ SESIÓN (Es la decoradora) --}}
            @auth
            {{-- Solo la admin ve las opciones de administración --}}
            @if (auth()->user()->esAdmin())
            <li>
                <a href="{{ route('admin.projects.create') }}" class="text-amber-700 hover:underline text-sm font-semibold">
                + Nueva Ambientación
            </a>
        </li>
        @endif
        
        {{-- Todos los logueados ven su nombre y el botón de salir --}}
        <li class="text-sm text-stone-500">Hola, {{ auth()->user()->name }}</li>
        <li>
            <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-stone-400 hover:text-red-600 text-sm transition">
                Cerrar sesión
            </button>
        </form>
    </li>
    @else
    <li>
        <a href="{{ route('login') }}" class="text-stone-500 hover:text-amber-700 text-sm transition">
            Ingresar
        </a>
    </li>
    @endauth
        </ul>
    </nav>
    </header>

    <!-- Contenido Principal -->
    <main class="flex-grow max-w-6xl w-full mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Pie de página -->
    <footer class="bg-stone-900 text-stone-400 py-6 mt-12 text-center text-sm border-t border-stone-800">
        <p>&copy; {{ date('Y') }} Simkus Eventos. Todos los derechos reservados.</p>
    </footer>

</body>
</html>