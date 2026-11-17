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
    public function pdf($id)
    {
        // Buscamos la solicitud por su id; si no existe, Laravel responde 404
        $booking = Booking::with(['category', 'services', 'user'])->findOrFail($id);
        
        $pdf = Pdf::loadView('bookings.pdf', compact('booking'));
        
        return $pdf->stream('presupuesto-' . $booking->id . '.pdf');
        }
}
