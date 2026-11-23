<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Simkus Eventos - Decoración')</title>
    
    <!-- Carga de Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
    img {
        user-select: none;
        -webkit-user-select: none;
        -webkit-touch-callout: none; /* Bloquea el menú al mantener apretado en móviles */
    }
    </style>
</head>
<body class="bg-stone-50 text-stone-800 font-sans min-h-screen flex flex-col">

    <!-- Barra de Navegación -->
     <header class="bg-white shadow-sm sticky top-0 z-30">
    <nav class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
        {{-- tu logo de siempre --}}
        <div class="text-xl font-serif font-bold tracking-wide text-amber-700">
            <a href="{{ route('porfolio.index') }}">Simkus Eventos</a>
        </div>
        
        @auth
        <button id="btn-menu" class="text-2xl text-stone-700 px-2" aria-label="Abrir menú">☰</button>
        @else
        <div class="flex items-center gap-4 text-sm font-medium">
            <a href="{{ route('login') }}" class="text-stone-600 hover:text-amber-700 transition">Ingresar</a>
            <a href="{{ route('register.show') }}" class="bg-stone-900 text-white px-4 py-2 rounded-full hover:bg-stone-800 transition">
                Registrarse
            </a>
        </div>
        @endauth
    </nav>
    </header>

    @auth
    <div id="menu-fondo" class="hidden fixed inset-0 bg-black/40 z-40"></div>
    

    <aside id="menu-panel" class="hidden fixed top-0 right-0 h-full w-72 bg-white shadow-xl z-50 p-6 flex-col">
    <button id="btn-cerrar" class="self-end text-2xl text-stone-500" aria-label="Cerrar menú">✕</button>
    <ul class="mt-6 space-y-4 font-medium text-stone-700">
            <li><a href="{{ route('porfolio.index') }}" class="hover:text-amber-700 transition">Porfolio</a></li>

            @auth
                @if (auth()->user()->esAdmin())
                    <li>
                        <a href="{{ route('admin.projects.index') }}" class="text-stone-800 hover:text-amber-700 font-semibold transition">
                            Administrar Porfolio
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.projects.create') }}" class="bg-amber-700 text-white px-4 py-2 rounded-full hover:bg-amber-800 transition">
                            + Nuevo Proyecto
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bookings.index') }}" class="text-stone-800 hover:text-amber-700 font-semibold transition">
                            Presupuestos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.services.index') }}" class="text-stone-800 hover:text-amber-700 font-semibold transition">
                            Servicios
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories.index') }}" class="text-stone-800 hover:text-amber-700 font-semibold transition">
                            Categorías
                        </a>
                    </li>
                     @else
                        {{-- Opciones para clientes logueados --}}
                        <li>
                            <a href="{{ route('bookings.mine') }}" class="text-stone-800 hover:text-amber-700 font-semibold transition">
                                Mis Presupuestos
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('bookings.create') }}" class="bg-amber-700 text-white px-4 py-2 rounded-full hover:bg-amber-800 transition">
                                Pedir Presupuesto
                             </a>
                        </li>
                    @endif

                <li>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-stone-400 hover:text-red-600 transition">
                            Salir
                        </button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}" class="hover:text-amber-700 transition">
                    Ingresar    
                    </a></li>
                <li>
                    <a href="{{ route('register.show') }}" class="bg-stone-900 text-white px-4 py-2 rounded-full hover:bg-stone-800 transition">
                        Registrarse
                    </a>
                </li>
            @endauth
        </ul> 
     </aside>
     @endauth

    <!-- Contenido Principal -->
    <main class="flex-grow max-w-6xl w-full mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Pie de página -->
    <footer class="bg-stone-900 text-stone-400 py-6 mt-12 text-center text-sm border-t border-stone-800">
        <p>&copy; {{ date('Y') }} Simkus Eventos. Todos los derechos reservados.</p>
    </footer>

    <!-- Un poco mas de seguridad mediante javaScript para evitar que puedan descargar las imágenes de la galería del evento. Esto no es 100% seguro, pero ayuda a disuadir a usuarios menos experimentados. -->
    <script>
    // 1. Evita el menú contextual (clic derecho) sobre cualquier imagen
    document.addEventListener('contextmenu', function (e) {
        if (e.target.tagName === 'IMG') {
            e.preventDefault();
        }
    });

    // 2. Evita que puedan arrastrar la imagen hacia otra pestaña o al escritorio
    document.addEventListener('dragstart', function (e) {
        if (e.target.tagName === 'IMG') {
            e.preventDefault();
        }
    });

    // 3. Menú desplegable
const btnMenu   = document.querySelector('#btn-menu');
const btnCerrar = document.querySelector('#btn-cerrar');
const panel     = document.querySelector('#menu-panel');
const fondo     = document.querySelector('#menu-fondo');

function abrirMenu() {
    panel.classList.remove('hidden');
    panel.classList.add('flex');      // para que funcionen flex-col y self-end
    fondo.classList.remove('hidden');
}

function cerrarMenu() {
    panel.classList.add('hidden');
    panel.classList.remove('flex');
    fondo.classList.add('hidden');
}

if (btnMenu) {
    btnMenu.addEventListener('click', abrirMenu);
    btnCerrar.addEventListener('click', cerrarMenu);
    fondo.addEventListener('click', cerrarMenu);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') cerrarMenu();
    });

    // Cerrar también con la tecla Escape
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') cerrarMenu();
});
}


    </script>

</body>
</html>