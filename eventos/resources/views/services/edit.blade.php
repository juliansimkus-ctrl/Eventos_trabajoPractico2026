@extends('layouts.eventos')

@section('title', 'Editar Servicio - Simkus Eventos')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-stone-100 my-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-serif font-bold text-stone-900">Editar Servicio</h1>
            <p class="text-stone-500 text-sm font-light">Modificá el nombre, detalle o precio del servicio.</p>
        </div>
        <a href="{{ route('admin.services.index') }}" class="text-sm text-stone-500 hover:text-amber-700 transition">&larr; Volver</a>
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

    <form action="{{ route('admin.services.update', $service->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-semibold text-stone-700 mb-1">Nombre del servicio</label>
            <input type="text" id="name" name="name" value="{{ old('name', $service->name) }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition">
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-stone-700 mb-1">Descripción</label>
            <input type="text" id="description" name="description" value="{{ old('description', $service->description) }}"
                   class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition">
        </div>

        <div>
            <label for="price" class="block text-sm font-semibold text-stone-700 mb-1">Precio ($)</label>
            <input type="number" id="price" name="price" value="{{ old('price', $service->price) }}" min="0" step="100" required
                   class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition">
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-stone-900 text-white font-semibold py-3 px-6 rounded-xl hover:bg-stone-800 shadow-sm transition">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection