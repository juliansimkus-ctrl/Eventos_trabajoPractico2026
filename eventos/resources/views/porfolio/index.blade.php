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
        <h2 class="text-2xl font-serif font-bold text-stone-900 mb-8 border-b border-stone-200 pb-4">Nuestras últimas ambientaciones</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse ($projects as $project)
                <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col border border-stone-100">
                    <!-- Contenedor de Imagen (Falsa por ahora con un color suave) -->
                    <div class="h-48 bg-amber-100/50 flex items-center justify-center text-stone-400">
                        <span>📷 Espacio para foto de porfolio</span>
                    </div>
                    
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="inline-block bg-amber-50 text-amber-800 text-xs font-semibold px-2.5 py-1 rounded-full mb-3 uppercase tracking-wider">
                                {{ $project->category->name }}
                            </span>
                            <h3 class="text-lg font-bold text-stone-900 mb-2">{{ $project->title }}</h3>
                            <p class="text-stone-600 text-sm line-clamp-3 mb-4">{{ Str::limit($project->description, 100) }}</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-stone-100 mt-auto text-xs text-stone-500">
                            @if($project->event_date)
                                <span>{{ $project->event_date->format('d/m/Y') }}</span>
                            @endif
                            <a href="#" class="text-amber-700 font-semibold hover:underline">Ver galería &rarr;</a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-12 text-stone-500 bg-white rounded-2xl border border-stone-100">
                    <p>Próximamente subiremos fotos de nuestros eventos más recientes.</p>
                </div>
            @endforelse
        </div>
   </section>
@endsection