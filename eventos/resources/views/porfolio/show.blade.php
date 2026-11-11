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

    {{-- Comentarios --}}
    <section class="mt-12 bg-white rounded-3xl p-8 shadow-sm border border-stone-100">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-2">
            <h2 class="text-2xl font-serif font-bold text-stone-900">Comentarios sobre este evento</h2>
            @if ($project->canReceiveComments())
                <span class="text-xs text-emerald-700 font-medium">
                    Abiertos hasta el {{ $project->event_date->copy()->addDays(7)->format('d/m/Y') }}
                </span>
            @endif
        </div>

        @if (session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-6 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario (solo visible durante los 7 días posteriores al evento) --}}
        @if ($project->canReceiveComments())
            <form action="{{ route('comments.store', $project->id) }}" method="POST" class="space-y-4 mb-8 pb-8 border-b border-stone-100">
                @csrf
                <div>
                    <label for="author_name" class="block text-sm font-semibold text-stone-700 mb-1">Tu nombre</label>
                    <input id="author_name" type="text" name="author_name" value="{{ old('author_name') }}" maxlength="100" required
                           placeholder="Ej: Camila"
                           class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 text-sm focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition">
                </div>

                <div>
                    <label for="content" class="block text-sm font-semibold text-stone-700 mb-1">Comentario</label>
                    <textarea id="content" name="content" rows="3" maxlength="500" required
                              placeholder="Contanos qué te pareció esta ambientación..."
                              class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 text-sm focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition resize-none">{{ old('content') }}</textarea>
                </div>

                <button type="submit" class="bg-stone-900 text-white text-sm font-semibold px-6 py-2.5 rounded-xl hover:bg-stone-800 transition">
                    Dejar comentario
                </button>
            </form>
        @else
            <div class="bg-stone-50 text-stone-500 p-4 rounded-2xl mb-8 text-sm border border-stone-100">
                El período de 7 días posteriores al evento para dejar comentarios ya finalizó.
            </div>
        @endif

        {{-- Listado permanente de comentarios --}}
        <div class="space-y-4">
            @forelse ($project->comments as $comment)
                <article class="bg-stone-50/70 p-4 rounded-2xl border border-stone-100">
                    <div class="flex justify-between items-center mb-1">
                        <strong class="text-sm text-stone-900">{{ $comment->author_name }}</strong>
                        <span class="text-xs text-stone-400">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-stone-600 leading-relaxed">{{ $comment->content }}</p>
                </article>
            @empty
                <p class="text-sm text-stone-500">Todavía no hay comentarios en este evento.</p>
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