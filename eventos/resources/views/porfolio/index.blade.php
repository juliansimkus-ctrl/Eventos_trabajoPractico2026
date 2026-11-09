@extends('layouts.eventos')

@section('content')
   <!-- Sección Hero -->
   <section class="text-center py-20 bg-gradient-to-b from-amber-50 to-transparent rounded-3xl mb-12">
       <h1 class="text-5xl font-serif font-bold text-stone-900 mb-4 tracking-tight">Simkus Eventos</h1>
       <p class="text-xl text-stone-600 font-light italic max-w-md mx-auto">Decoramos tus momentos felices.</p>
       <div class="mt-8">
           <a href="{{ route('bookings.create') }}" class="inline-block bg-amber-700 text-white font-semibold px-8 py-3 rounded-full hover:bg-amber-800 shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
               Pedí tu presupuesto gratuito
           </a>
       </div>
   </section>

   <!-- Sección Últimas Ambientaciones -->
   <section class="mt-16">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8 border-b border-stone-200 pb-4">
    <h2 class="text-2xl font-serif font-bold text-stone-900">Nuestras últimas ambientaciones</h2>
    
    <!--FORM DE SELECT PARA FILTRAR EVENTOS -->
    <form action="{{ route('porfolio.index') }}" method="GET">
        <label for="category" class="text-sm font-semibold text-stone-700 mr-2">Tipo de evento:</label>
                    <select name="category" id="category"
                    class="px-4 py-2 rounded-xl border border-stone-200">
                    <option value="">Todos</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                    {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
                    </select>
                </form>
        </div>
        <div id="grilla-proyectos" class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @include('porfolio._tarjetas')
        </div>
   </section>

   {{-- ... grilla de tarjetas ... --}}
   
   <script>
        const select = document.querySelector('#category');
        const grilla = document.querySelector('#grilla-proyectos');

        select.addEventListener('change', async () => {
            grilla.textContent = 'Cargando...';
            try {
                const respuesta = await fetch(`{{ route('porfolio.filtrar') }}?category=${select.value}`);
                if (!respuesta.ok) throw new Error();
                grilla.innerHTML = await respuesta.text();
            } catch {
                grilla.textContent = 'No pudimos cargar los trabajos.';
            }
        });
    </script>
@endsection