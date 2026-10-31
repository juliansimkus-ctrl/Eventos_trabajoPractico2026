@extends('layouts.eventos')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-stone-100">
    <h1 class="text-3xl font-serif font-bold text-stone-900 mb-2">Contanos sobre tu evento</h1>
    <p class="text-stone-600 mb-8 font-light">Completá los datos y la decoradora se pondrá en contacto para diseñar tu presupuesto ideal.</p>

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

    @if (session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl mb-8 font-medium">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Selección de Tipo de Evento en Tarjetas -->
        <div>
            <span class="block text-sm font-semibold text-stone-700 mb-3">¿Qué tipo de evento vas a organizar?</span>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($categories as $category)
                <label class="relative border border-stone-200 rounded-xl p-4 flex items-start space-x-3 cursor-pointer hover:border-amber-600 transition bg-stone-50/50 has-[:checked]:border-amber-700 has-[:checked]:bg-amber-50/40">
                    <input type="radio"
                       name="event_category_id"
                       value="{{ $category->id }}"
                       {{ old('event_category_id') == $category->id ? 'checked' : '' }}
                       class="mt-1 text-amber-700 focus:ring-amber-600 border-stone-300"
                       required>
                    <div>
                        <strong class="block text-sm text-stone-900">{{ $category->name }}</strong>
                        <p class="text-xs text-stone-500 mt-1 leading-relaxed">{{ $category->description }}</p>
                    </div>
                </label>
                @endforeach
            </div>
            @error('event_category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Campos de Datos Personales en Grid de 2 Columnas -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nombre" class="block text-sm font-semibold text-stone-700 mb-1">Nombre completo</label>
                <input id="nombre" name="client_name" maxlength="255" value="{{ old('client_name') }}" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition" required>
                @error('client_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-stone-700 mb-1">Correo electrónico</label>
                <input id="email" type="email" name="client_email" maxlength="255" value="{{ old('client_email') }}" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition" required>
                @error('client_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <label for="telefono" class="block text-sm font-semibold text-stone-700 mb-1">Número de teléfono</label>
                <input id="telefono" type="tel" name="client_phone" maxlength="50" value="{{ old('client_phone') }}" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition" required>
                @error('client_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-1">
                <label for="fecha" class="block text-sm font-semibold text-stone-700 mb-1">Fecha estimada</label>
                <input id="fecha" type="date" name="estimated_date" value="{{ old('estimated_date') }}" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition" required>
                @error('estimated_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-1">
                <label for="invitados" class="block text-sm font-semibold text-stone-700 mb-1">Cantidad de invitados</label>
                <input id="invitados" name="estimated_guests" type="number" min="1" max="350" value="{{ old('estimated_guests') }}" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition">
                @error('estimated_guests') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="ideas" class="block text-sm font-semibold text-stone-700 mb-1">Ideas o recomendaciones para la ambientación</label>
            <textarea id="ideas" name="ideas_or_details" maxlength="2000" rows="4" class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-stone-800 focus:ring-2 focus:ring-amber-600/20 focus:border-amber-700 outline-none transition resize-none" placeholder="Contanos qué colores te gustan, la temática o si es en salón/quinta..." required>{{ old('ideas_or_details') }}</textarea>
            @error('ideas_or_details') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-stone-900 text-white font-semibold py-3 px-6 rounded-xl hover:bg-stone-800 shadow-sm transition transform active:scale-[0.98]">
                Enviar Solicitud
            </button>
        </div>
    </form>
</div>
@endsection