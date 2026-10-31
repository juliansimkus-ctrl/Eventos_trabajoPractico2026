<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\EventCategory;
use Illuminate\Http\Request;
//para usar la liibreria
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    /**
     * Muestra el formulario de contacto/cotización.
     */
    public function create()
    {
        $categories = EventCategory::all();
        return view('bookings.create', compact('categories'));
    }

    /**
     * Procesa y guarda la solicitud del cliente.
     */
    public function store(Request $request)
    {
        // Validamos estrictamente los datos que entran de la web
        $validated = $request->validate([
            'event_category_id' => 'required|exists:event_categories,id',
            'client_name'       => 'required|string|max:255',
            'client_email'      => 'required|email|max:255',
            'client_phone'      => 'nullable|string|max:50',
            'estimated_date'    => 'required|date|after:today', // La fiesta debe ser a futuro
            'estimated_guests'  => 'nullable|integer|min:1',
            'ideas_or_details'  => 'nullable|string|max:2000',
        ]);
        
        // Guardamos la solicitud y nos quedamos con el Booking creado (incluye su id)
        // guarda en la base y devuelve el objeto creado, que ya tiene el id que le asignó la base.
        $booking = Booking::create($validated);
        
        // Redirigimos al presupuesto en PDF de esa solicitud
        return redirect()->route('bookings.pdf', $booking->id);
    }

    /**
     ** Genera y descarga el presupuesto en PDF de una solicitud.
     */
    public function pdf(Booking $booking)
    {
        $pdf = Pdf::loadView('bookings.pdf', compact('booking'));
        
        return $pdf->stream('presupuesto-' . $booking->id . '.pdf');
    }
}
