<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\EventCategory;
use Illuminate\Http\Request;
//para usar la liibreria
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Service;
use Illuminate\Support\Arr;

class BookingController extends Controller
{
    /**
     * Muestra el formulario de contacto/cotización, mas los servicios.
     */
    public function create()
    {
        $categories = EventCategory::all();
        $services = Service::all();
        
        return view('bookings.create', compact('categories', 'services'));
    }

    /**
     * Procesa y guarda la solicitud del cliente.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_category_id' => 'required|exists:event_categories,id',
            'estimated_date'    => 'required|date|after:today',
            'estimated_guests'  => 'required|integer|min:1|max:350',
            'ideas_or_details'  => 'nullable|string|max:2000',
            'services'          => 'nullable|array',
            'services.*'        => 'integer|exists:services,id',
        ]);
        
        // Creo la solicitud A TRAVÉS del usuario logueado: el user_id se completa solo
        $booking = auth()->user()->bookings()->create(Arr::except($validated, ['services']));

        // N:N: guardo en booking_service un par por cada servicio elegido
        $booking->services()->attach($validated['services'] ?? []);
        
        return redirect()->route('bookings.pdf', $booking->id);
    }
    
    /**
     ** Genera y muestra el presupuesto en PDF de una solicitud.
     */
        /**
     * Muestra únicamente los presupuestos del usuario logueado.
     */
    public function misPresupuestos()
    {
        $bookings = auth()->user()->bookings()
            ->with(['category', 'services'])
            ->latest()
            ->get();

        return view('bookings.mine', compact('bookings'));
    }

    /**
     * Genera y muestra el presupuesto en PDF (solo para el dueño o el admin).
     */
    public function pdf($id)
    {
        $booking = Booking::with(['category', 'services', 'user'])->findOrFail($id);

        // Si no es administrador y el presupuesto no le pertenece, bloqueamos el acceso
        if (!auth()->user()->esAdmin() && $booking->user_id !== auth()->id()) {
            abort(403, 'No tenés permiso para visualizar este presupuesto.');
        }

        $pdf = Pdf::loadView('bookings.pdf', compact('booking'));

        return $pdf->stream('presupuesto-' . $booking->id . '.pdf');
    }

       /**
     * Muestra el listado de todas las solicitudes de presupuesto (Solo Admin).
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'category', 'services'])
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Actualiza el estado de una solicitud (pendiente, aprobado, rechazado).
     */
    public function updateStatus(Request $request, Booking $booking)
    {
    $validated = $request->validate([
        'status' => 'required|in:pending,contacted,budgeted,cancelled',
    ]);

    $booking->update([
        'status' => $validated['status'],
    ]);

    return back()->with('success', 'Estado del presupuesto #' . $booking->id . ' actualizado.');
    }
}

