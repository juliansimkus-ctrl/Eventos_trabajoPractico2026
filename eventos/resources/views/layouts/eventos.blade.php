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
            <ul class="flex space-x-6 font-medium text-stone-600">
                <li><a href="/" class="hover:text-amber-700 transition">Inicio</a></li>
                <li><a href="{{ route('bookings.create') }}" class="bg-amber-700 text-white px-4 py-2 rounded-full hover:bg-amber-800 transition text-sm">Pedir Presupuesto</a></li>
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