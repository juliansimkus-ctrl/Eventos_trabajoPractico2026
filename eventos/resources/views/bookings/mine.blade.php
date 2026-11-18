@extends('layouts.eventos')

@section('title', 'Mis Presupuestos - Simkus Eventos')

@section('content')
<div class="max-w-5xl mx-auto my-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-serif font-bold text-stone-900">Mis Presupuestos</h1>
            <p class="text-stone-500 text-sm font-light">Consultá el estado de tus solicitudes y descargá tus presupuestos en PDF.</p>
        </div>
        <a href="{{ route('bookings.create') }}" class="inline-block bg-amber-700 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-amber-800 transition text-sm text-center">
            + Solicitar Nuevo Presupuesto
        </a>
    </div>

    <div class="space-y-4">
        @forelse ($bookings as $booking)
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-stone-100 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="bg-amber-50 text-amber-800 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">
                            {{ $booking->category->name }}
                        </span>

                        @php
                            $estados = [
                                'pending'   => ['texto' => '🟡 Pendiente de revisión', 'clase' => 'bg-amber-50 text-amber-700 border-amber-200'],
                                'contacted' => ['texto' => '🔵 En contacto',           'clase' => 'bg-sky-50 text-sky-700 border-sky-200'],
                                'budgeted'  => ['texto' => '🟢 Presupuestado',         'clase' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
                                'cancelled' => ['texto' => '🔴 Cancelado',             'clase' => 'bg-red-50 text-red-700 border-red-200'],
                            ];
                            $estadoActual = $estados[$booking->status ?? 'pending'] ?? $estados['pending'];
                        @endphp

                        <span class="text-xs font-medium px-2.5 py-0.5 rounded-full border {{ $estadoActual['clase'] }}">
                            {{ $estadoActual['texto'] }}
                        </span>
                    </div>

                    <div class="text-sm text-stone-600 flex flex-wrap gap-4 pt-1">
                        <span>📅 Fecha estimada: <strong>{{ $booking->estimated_date->format('d/m/Y') }}</strong></span>
                        <span>👥 Invitados: <strong>{{ $booking->estimated_guests }}</strong></span>
                    </div>

                    @if ($booking->services->count() > 0)
                        <p class="text-xs text-stone-500">
                            <strong>Servicios:</strong> {{ $booking->services->pluck('name')->join(', ') }}
                        </p>
                    @endif
                </div>

                <div class="flex sm:items-center justify-between md:justify-end gap-6 pt-4 md:pt-0 border-t md:border-t-0 border-stone-100">
                    <div class="text-left md:text-right">
                        <span class="block text-xs text-stone-400">Estimado total</span>
                        <span class="text-xl font-bold text-stone-900">
                            ${{ number_format($booking->precio_estimado, 0, ',', '.') }}
                        </span>
                    </div>

                    <a href="{{ route('bookings.pdf', $booking->id) }}" target="_blank"
                       class="bg-stone-900 text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-stone-800 transition whitespace-nowrap">
                        Ver PDF
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-white p-12 rounded-3xl shadow-sm border border-stone-100 text-center space-y-4">
                <p class="text-stone-500">Todavía no solicitaste ningún presupuesto.</p>
                <a href="{{ route('bookings.create') }}" class="inline-block bg-amber-700 text-white font-semibold px-6 py-2.5 rounded-full hover:bg-amber-800 transition text-sm">
                    Cotizar mi primer evento
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection