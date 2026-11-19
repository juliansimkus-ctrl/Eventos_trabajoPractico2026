@extends('layouts.eventos')

@section('title', 'Categorías de Eventos - Simkus Eventos')

@section('content')
<div class="max-w-6xl mx-auto my-8 space-y-8">
    <div>
        <h1 class="text-3xl font-serif font-bold text-stone-900">Categorías de Eventos</h1>
        <p class="text-stone-500 text-sm font-light">Administrá los tipos de eventos y sus tarifas base para calcular presupuestos.</p>
    </div>

    @if (session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario para agregar categoría --}}
    <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-stone-100">
        <h2 class="text-lg font-serif font-bold text-stone-900 mb-4">Agregar Nueva Categoría</h2>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            @csrf

            <div>
                <label for="name" class="block text-xs font-semibold text-stone-700 mb-1">Nombre</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Ej: Baby Shower" required
                       class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 text-sm focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition">
            </div>

            <div>
                <label for="description" class="block text-xs font-semibold text-stone-700 mb-1">Descripción (Opcional)</label>
                <input type="text" id="description" name="description" value="{{ old('description') }}" placeholder="Ej: Ambientación íntima"
                       class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 text-sm focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition">
            </div>

            <div>
                <label for="base_price" class="block text-xs font-semibold text-stone-700 mb-1">Precio Base ($)</label>
                <input type="number" id="base_price" name="base_price" value="{{ old('base_price') }}" min="0" step="100" placeholder="150000" required
                       class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 text-sm focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition">
            </div>

            <div class="flex gap-3 items-end">
                <div class="flex-1">
                    <label for="price_per_guest" class="block text-xs font-semibold text-stone-700 mb-1">Por Invitado ($)</label>
                    <input type="number" id="price_per_guest" name="price_per_guest" value="{{ old('price_per_guest') }}" min="0" step="100" placeholder="2500" required
                           class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 text-sm focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition">
                </div>

                <button type="submit" class="bg-amber-700 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-amber-800 transition text-sm whitespace-nowrap">
                    + Crear
                </button>
            </div>
        </form>
    </div>

    {{-- Tabla de categorías existentes --}}
    <div class="bg-white rounded-3xl shadow-sm border border-stone-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-stone-50 border-b border-stone-100 text-xs uppercase text-stone-500 tracking-wider">
                        <th class="py-4 px-6">Categoría</th>
                        <th class="py-4 px-6">Precio Base</th>
                        <th class="py-4 px-6">Por Invitado</th>
                        <th class="py-4 px-6">Uso</th>
                        <th class="py-4 px-6 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-sm">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-stone-50/50 transition">
                            <td class="py-4 px-6">
                                <p class="font-semibold text-stone-900">{{ $category->name }}</p>
                                @if ($category->description)
                                    <p class="text-xs text-stone-500">{{ $category->description }}</p>
                                @endif
                            </td>
                            <td class="py-4 px-6 font-medium text-stone-800 whitespace-nowrap">
                                ${{ number_format($category->base_price, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 font-medium text-stone-800 whitespace-nowrap">
                                ${{ number_format($category->price_per_guest, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="flex items-center gap-2 text-xs">
                                    <span class="bg-stone-100 text-stone-700 font-medium px-2.5 py-1 rounded-full">
                                        {{ $category->projects_count }} {{ $category->projects_count === 1 ? 'proyecto' : 'proyectos' }}
                                    </span>
                                    <span class="bg-amber-50 text-amber-800 font-medium px-2.5 py-1 rounded-full">
                                        {{ $category->bookings_count }} {{ $category->bookings_count === 1 ? 'pedido' : 'pedidos' }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-right space-x-3 whitespace-nowrap">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-amber-700 font-semibold hover:underline">
                                    Editar
                                </a>

                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Segura que querés eliminar esta categoría?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 font-semibold hover:underline">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 px-6 text-center text-stone-500">
                                Todavía no hay categorías cargadas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection