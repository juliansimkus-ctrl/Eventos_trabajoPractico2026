<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\EventCategory;
use Illuminate\Http\Request;

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

        // Guardamos en la base de datos usando asignación masiva
        Booking::create($validated);

        // Redireccionamos al cliente con un mensaje de éxito
        return redirect()->route('bookings.create')
            ->with('success', '¡Tu solicitud fue enviada con éxito! La decoradora se pondrá en contacto pronto.');
    }
}
