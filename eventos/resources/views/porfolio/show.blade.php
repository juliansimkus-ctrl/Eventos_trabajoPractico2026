@extends('layouts.eventos')

@section('title', $project->title . ' - Simkus Eventos')

@section('content')
    <a href="{{ route('porfolio.index') }}" class="text-amber-700 font-semibold hover:underline text-sm">
        &larr; Volver a los trabajos
    </a>

    {{-- Encabezado del evento --}}
    <section class="mt-6 bg-white rounded-3xl overflow-hidden shadow-sm border border-stone-100">
        @if ($project->image_url)
            <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="w-full h-80 object-cover">
        @endif

        <div class="p-8">
            <span class="inline-block bg-amber-50 text-amber-800 text-xs font-semibold px-2.5 py-1 rounded-full mb-3 uppercase tracking-wider">
                {{ $project->category->name }}
            </span>
            <h1 class="text-4xl font-serif font-bold text-stone-900 mb-3">{{ $project->title }}</h1>

            <div class="flex flex-wrap gap-4 text-sm text-stone-500 mb-4">
                @if ($project->event_date)
                    <span>📅 {{ $project->event_date->format('d/m/Y') }}</span>
                @endif
                @if ($project->location)
                    <span>📍 {{ $project->location }}</span>
                @endif
            </div>

            <p class="text-stone-700 leading-relaxed">{{ $project->description }}</p>
        </div>
    </section>

    {{-- Galería --}}
    <section class="mt-12">
        <h2 class="text-2xl font-serif font-bold text-stone-900 mb-6">Galería</h2>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @forelse ($project->images as $imagen)
                <figure class="bg-white rounded-2xl overflow-hidden shadow-sm border border-stone-100">
                    <a href="{{ $imagen->url }}" target="_blank">
                        <img src="{{ $imagen->url }}" alt="{{ $imagen->descripcion ?? $project->title }}"
                             class="h-56 w-full object-cover hover:opacity-90 transition">
                    </a>
                    @if ($imagen->descripcion)
                        <figcaption class="p-3 text-sm text-stone-600">{{ $imagen->descripcion }}</figcaption>
                    @endif
                </figure>
            @empty
                <p class="col-span-3 text-stone-500">Todavía no subimos fotos de este evento.</p>
            @endforelse
        </div>
    </section>

    {{-- Llamado a la acción --}}
    <div class="text-center mt-12">
        <a href="{{ route('bookings.create') }}" class="inline-block bg-amber-700 text-white font-semibold px-8 py-3 rounded-full hover:bg-amber-800 shadow-md transition">
            Quiero algo así para mi evento
        </a>
    </div>
@endsection