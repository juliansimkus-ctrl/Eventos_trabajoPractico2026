@extends('layouts.eventos')

@section('title', 'Administrar Proyectos - Simkus Eventos')

@section('content')
<div class="max-w-5xl mx-auto my-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-serif font-bold text-stone-900">Gestión del Porfolio</h1>
            <p class="text-stone-500 text-sm font-light">Editá los detalles de tus ambientaciones o eliminá trabajos publicados.</p>
        </div>
        <a href="{{ route('admin.projects.create') }}" class="inline-block bg-amber-700 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-amber-800 transition text-sm text-center">
            + Nueva Ambientación
        </a>
    </div>

    @if (session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-stone-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-stone-50 border-b border-stone-100 text-xs uppercase text-stone-500 tracking-wider">
                        <th class="py-4 px-6">Proyecto</th>
                        <th class="py-4 px-6">Categoría</th>
                        <th class="py-4 px-6">Fecha</th>
                        <th class="py-4 px-6 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-sm">
                    @forelse ($projects as $project)
                        <tr class="hover:bg-stone-50/50 transition">
                            <td class="py-4 px-6 font-medium text-stone-900">
                                <a href="{{ route('porfolio.show', $project->slug) }}" class="hover:text-amber-700 transition">
                                    {{ $project->title }}
                                </a>
                            </td>
                            <td class="py-4 px-6 text-stone-600">
                                <span class="bg-amber-50 text-amber-800 text-xs font-semibold px-2.5 py-1 rounded-full">
                                    {{ $project->category->name }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-stone-500">
                                {{ $project->event_date ? $project->event_date->format('d/m/Y') : 'Sin fecha' }}
                            </td>
                            <td class="py-4 px-6 text-right space-x-3">
                                <a href="{{ route('admin.projects.edit', $project->id) }}" class="text-amber-700 font-semibold hover:underline">
                                    Editar
                                </a>

                                <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Segura que querés eliminar este proyecto y todas sus fotos?');">
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
                                Todavía no hay proyectos cargados en el porfolio.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection