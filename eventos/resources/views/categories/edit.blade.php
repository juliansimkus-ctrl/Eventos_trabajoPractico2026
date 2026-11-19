@extends('layouts.eventos')

@section('title', 'Editar Categoría - Simkus Eventos')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-stone-100 my-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-serif font-bold text-stone-900">Editar Categoría</h1>
            <p class="text-stone-500 text-sm font-light">Modificá el nombre o los valores de referencia para esta categoría.</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="text-sm text-stone-500 hover:text-amber-700 transition">&larr; Volver</a>
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

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-semibold text-stone-700 mb-1">Nombre de la categoría</label>
            <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition">
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-stone-700 mb-1">Descripción (Opcional)</label>
            <input type="text" id="description" name="description" value="{{ old('description', $category->description) }}"
                   class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="base_price" class="block text-sm font-semibold text-stone-700 mb-1">Precio Base ($)</label>
                <input type="number" id="base_price" name="base_price" value="{{ old('base_price', $category->base_price) }}" min="0" step="100" required
                       class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition">
            </div>

            <div>
                <label for="price_per_guest" class="block text-sm font-semibold text-stone-700 mb-1">Precio por Invitado ($)</label>
                <input type="number" id="price_per_guest" name="price_per_guest" value="{{ old('price_per_guest', $category->price_per_guest) }}" min="0" step="100" required
                       class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition">
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-stone-900 text-white font-semibold py-3 px-6 rounded-xl hover:bg-stone-800 shadow-sm transition">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection