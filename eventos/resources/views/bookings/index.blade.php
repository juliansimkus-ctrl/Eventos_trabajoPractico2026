@extends('layouts.eventos')

@section('title', 'Solicitudes de Presupuesto - Simkus Eventos')

@section('content')
<div class="max-w-6xl mx-auto my-8">
    <div class="mb-8">
        <h1 class="text-3xl font-serif font-bold text-stone-900">Solicitudes de Presupuesto</h1>
        <p class="text-stone-500 text-sm font-light">Revisá los pedidos de cotización enviados por los clientes y gestioná su estado.</p>
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
                        <th class="py-4 px-5">Cliente</th>
                        <th class="py-4 px-5">Evento y Fecha</th>
                        <th class="py-4 px-5">Invitados / Servicios</th>
                        <th class="py-4 px-5">Estimado</th>
                        <th class="py-4 px-5">Estado</th>
                        <th class="py-4 px-5 text-right">PDF</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-sm">
                    @forelse ($bookings as $booking)
                        <tr class="hover:bg-stone-50/50 transition align-top">
                            <td class="py-4 px-5">
                                <p class="font-semibold text-stone-900">{{ $booking->user->name }}</p>
                                <p class="text-xs text-stone-500">{{ $booking->user->email }}</p>
                                @if ($booking->user->phone)
                                    <p class="text-xs text-stone-400">📞 {{ $booking->user->phone }}</p>
                                @endif
                            </td>

                            <td class="py-4 px-5">
                                <span class="inline-block bg-amber-50 text-amber-800 text-xs font-semibold px-2.5 py-0.5 rounded-full mb-1">
                                    {{ $booking->category->name }}
                                </span>
                                <p class="text-stone-600 text-xs">
                                    📅 {{ $booking->estimated_date->format('d/m/Y') }}
                                </p>
                            </td>

                            <td class="py-4 px-5">
                                <p class="text-stone-700 font-medium text-xs mb-1">
                                    {{ $booking->estimated_guests }} invitados
                                </p>
                                @if ($booking->services->count() > 0)
                                    <ul class="text-xs text-stone-500 list-disc list-inside">
                                        @foreach ($booking->services as $service)
                                            <li>{{ $service->name }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-xs text-stone-400 italic">Sin servicios extra</span>
                                @endif

                                @if ($booking->ideas_or_details)
                                    <p class="mt-2 text-xs text-stone-500 bg-stone-50 p-2 rounded-lg border border-stone-100">
                                        "{{ $booking->ideas_or_details }}"
                                    </p>
                                @endif
                            </td>

                            <td class="py-4 px-5 font-semibold text-stone-900 whitespace-nowrap">
                                ${{ number_format($booking->precio_estimado, 0, ',', '.') }}
                            </td>

                            <td class="py-4 px-5">
                                <form action="{{ route('admin.bookings.status', $booking->id) }}" method="POST">
                                     @csrf
                                        @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                    class="text-xs font-semibold px-3 py-1.5 rounded-xl border border-stone-200 bg-white text-stone-700 focus:border-amber-700 outline-none cursor-pointer">
                                    <option value="pending" {{ ($booking->status ?? 'pending') === 'pending' ? 'selected' : '' }}>
                                        🟡 Pendiente
                                    </option>
                                    <option value="contacted" {{ $booking->status === 'contacted' ? 'selected' : '' }}>
                                        🔵 Contactado
                                    </option>
                                    <option value="budgeted" {{ $booking->status === 'budgeted' ? 'selected' : '' }}>
                                        🟢 Presupuestado
                                    </option>
                                    <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>
                                        🔴 Cancelado
                                    </option>
                                </select>
                            </form>
                            </td>

                            <td class="py-4 px-5 text-right whitespace-nowrap">
                                <a href="{{ route('bookings.pdf', $booking->id) }}" target="_blank"
                                   class="inline-block text-amber-700 font-semibold hover:underline text-xs">
                                    Ver PDF &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 px-6 text-center text-stone-500">
                                Todavía no hay solicitudes de presupuesto registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection