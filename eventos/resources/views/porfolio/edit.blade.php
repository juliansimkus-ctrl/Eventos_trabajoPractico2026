@extends('layouts.eventos')

@section('title', 'Editar Proyecto - Simkus Eventos')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-stone-100 my-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-serif font-bold text-stone-900 mb-1">Editar Ambientación</h1>
            <p class="text-stone-500 text-sm font-light">Modificá los datos del evento o sumá nuevas fotos a la galería.</p>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="text-sm text-stone-500 hover:text-amber-700 transition">&larr; Volver</a>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-6 text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-sm font-semibold text-stone-700 mb-1">Título del Proyecto</label>
            <input type="text" id="title" name="title" value="{{ old('title', $project->title) }}" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition" required>
        </div>

        <div>
            <label for="event_category_id" class="block text-sm font-semibold text-stone-700 mb-1">Categoría de Evento</label>
            <select id="event_category_id" name="event_category_id" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition bg-white" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('event_category_id', $project->event_category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="location" class="block text-sm font-semibold text-stone-700 mb-1">Lugar / Salón</label>
                <input type="text" id="location" name="location" value="{{ old('location', $project->location) }}" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition">
            </div>

            <div>
                <label for="event_date" class="block text-sm font-semibold text-stone-700 mb-1">Fecha del Evento</label>
                <input type="date" id="event_date" name="event_date" value="{{ old('event_date', $project->event_date?->format('Y-m-d')) }}" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition">
            </div>
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-stone-700 mb-1">Descripción de la Ambientación</label>
            <textarea id="description" name="description" rows="5" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition resize-none" required>{{ old('description', $project->description) }}</textarea>
        </div>

        {{-- Fotos actuales del proyecto --}}
        @if ($project->images->count() > 0)
            <div>
                <span class="block text-sm font-semibold text-stone-700 mb-2">Fotos actuales en la galería ({{ $project->images->count() }})</span>
                <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                    @foreach ($project->images as $imagen)
                        <img src="{{ $imagen->url }}" alt="{{ $project->title }}" class="h-24 w-full object-cover rounded-xl border border-stone-200">
                    @endforeach
                </div>
            </div>
        @endif

        <div class="bg-stone-50 p-6 rounded-2xl border-2 border-dashed border-stone-200">
            <label class="block text-sm font-semibold text-stone-700 mb-2">Agregar más fotos (Opcional)</label>
            <input type="file" name="images[]" multiple accept="image/*" class="block w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 transition cursor-pointer">
        </div>

        <div class="flex items-center space-x-3 pt-2">
            <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $project->is_featured) ? 'checked' : '' }} class="w-4 h-4 text-amber-700 border-stone-300 rounded focus:ring-amber-600">
            <label for="is_featured" class="text-sm font-medium text-stone-700 cursor-pointer">Destacar este proyecto en la página de inicio</label>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-stone-900 text-white font-semibold py-3 px-6 rounded-xl hover:bg-stone-800 shadow-sm transition">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection