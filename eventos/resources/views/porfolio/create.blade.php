@extends('layouts.eventos')

@section('title', 'Publicar Nueva Ambientación - Simkus Eventos')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-stone-100 my-8">
    <div class="mb-8">
        <h1 class="text-3xl font-serif font-bold text-stone-900 mb-2">Publicar Nueva Ambientación</h1>
        <p class="text-stone-600 font-light">Cargá los detalles del evento realizado y subí las fotos para la galería pública.</p>
    </div>

    {{-- Listado de errores de validación si algo sale mal --}}
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-6 text-sm">
            <p class="font-bold mb-1">Por favor corregí los siguientes errores:</p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario preparado para enviar texto y archivos multimedia --}}
    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Campo: Título -->
        <div>
            <label for="title" class="block text-sm font-semibold text-stone-700 mb-1">Título del Proyecto</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Ej: Boda Romántica de Civil - Ana & Luis" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition" required>
        </div>

        <!-- Campo: Categoría -->
        <div>
            <label for="event_category_id" class="block text-sm font-semibold text-stone-700 mb-1">Categoría de Evento</label>
            <select id="event_category_id" name="event_category_id" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition bg-white" required>
                <option value="">Seleccioná una categoría</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('event_category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Campos: Lugar y Fecha en 2 Columnas -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="location" class="block text-sm font-semibold text-stone-700 mb-1">Lugar / Salón</label>
                <input type="text" id="location" name="location" value="{{ old('location') }}" placeholder="Ej: Salón Las Camelias o Quinta Luz" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition">
            </div>

            <div>
                <label for="event_date" class="block text-sm font-semibold text-stone-700 mb-1">Fecha del Evento</label>
                <input type="date" id="event_date" name="event_date" value="{{ old('event_date') }}" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition">
            </div>
        </div>

        <!-- Campo: Descripción -->
        <div>
            <label for="description" class="block text-sm font-semibold text-stone-700 mb-1">Descripción de la Ambientación</label>
            <textarea id="description" name="description" rows="5" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition resize-none" placeholder="Detallá los elementos utilizados, paleta de colores, arreglos florales, telas..." required>{{ old('description') }}</textarea>
        </div>

        <!-- Campo Especial: Subida de Múltiples Imágenes -->
        <div class="bg-stone-50 p-6 rounded-2xl border-2 border-dashed border-stone-200">
            <label class="block text-sm font-semibold text-stone-700 mb-2">Galería de Fotos (Podés seleccionar varias)</label>
            <input type="file" name="images[]" multiple accept="image/*" class="block w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 transition cursor-pointer" required>
            <p class="text-xs text-stone-400 mt-2">Formatos permitidos: JPG, PNG. Podés subir varias imágenes juntas manteniendo presionado la tecla Ctrl al hacer clic.</p>
        </div>

        <!-- Campo: Checkbox para Destacar en la Home -->
        <div class="flex items-center space-x-3 pt-2">
            <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="w-4 h-4 text-amber-700 border-stone-300 rounded focus:ring-amber-600">
            <label for="is_featured" class="text-sm font-medium text-stone-700 cursor-pointer">Destacar este proyecto en la página de inicio</label>
        </div>

        <!-- Botón de Envío -->
        <div class="pt-4">
            <button type="submit" class="w-full bg-stone-900 text-white font-semibold py-3 px-6 rounded-xl hover:bg-stone-800 shadow-sm transition transform active:scale-[0.98]">
                Guardar y Publicar en Porfolio
            </button>
        </div>
    </form>
</div>
@endsection