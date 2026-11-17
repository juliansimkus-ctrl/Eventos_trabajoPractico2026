@extends('layouts.eventos')

@section('title', 'Administrar Servicios - Simkus Eventos')

@section('content')
<div class="max-w-5xl mx-auto my-8 space-y-8">
    <div>
        <h1 class="text-3xl font-serif font-bold text-stone-900">Catálogo de Servicios</h1>
        <p class="text-stone-500 text-sm font-light">Agregá nuevos servicios adicionales o actualizá sus precios para los presupuestos.</p>
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

    {{-- Formulario para agregar un servicio nuevo --}}
    <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-stone-100">
        <h2 class="text-lg font-serif font-bold text-stone-900 mb-4">Agregar Nuevo Servicio</h2>

        <form action="{{ route('admin.services.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            @csrf

            <div>
                <label for="name" class="block text-xs font-semibold text-stone-700 mb-1">Nombre del servicio</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Ej: Barra de tragos" required
                       class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 text-sm focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition">
            </div>

            <div>
                <label for="description" class="block text-xs font-semibold text-stone-700 mb-1">Descripción breve</label>
                <input type="text" id="description" name="description" value="{{ old('description') }}" placeholder="Ej: Incluye bartender y cristalería"
                       class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 text-sm focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition">
            </div>

            <div class="flex gap-3 items-end">
                <div class="flex-1">
                    <label for="price" class="block text-xs font-semibold text-stone-700 mb-1">Precio ($)</label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" min="0" step="100" placeholder="85000" required
                           class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 text-sm focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition">
                </div>

                <button type="submit" class="bg-amber-700 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-amber-800 transition text-sm whitespace-nowrap">
                    + Agregar
                </button>
            </div>
        </form>
    </div>

    {{-- Listado de servicios existentes --}}
    <div class="bg-white rounded-3xl shadow-sm border border-stone-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-stone-50 border-b border-stone-100 text-xs uppercase text-stone-500 tracking-wider">
                        <th class="py-4 px-6">Servicio</th>
                        <th class="py-4 px-6">Descripción</th>
                        <th class="py-4 px-6">Precio</th>
                        <th class="py-4 px-6 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-sm">
                    @forelse ($services as $service)
                        <tr class="hover:bg-stone-50/50 transition">
                            <td class="py-4 px-6 font-semibold text-stone-900">{{ $service->name }}</td>
                            <td class="py-4 px-6 text-stone-500">{{ $service->description ?? 'Sin descripción' }}</td>
                            <td class="py-4 px-6 font-medium text-stone-800 whitespace-nowrap">
                                ${{ number_format($service->price, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-right space-x-3 whitespace-nowrap">
                                <a href="{{ route('admin.services.edit', $service->id) }}" class="text-amber-700 font-semibold hover:underline">
                                    Editar
                                </a>

                                <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Segura que querés eliminar este servicio?');">
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
                            <td colspan="4" class="py-8 px-6 text-center text-stone-500">
                                Todavía no hay servicios cargados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection