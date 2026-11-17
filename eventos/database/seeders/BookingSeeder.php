<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\EventCategory;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cliente = User::where('email', 'cliente@simkus.com')->first();
        $categorias = EventCategory::all();
        $servicios = Service::all();

        // Si por algún motivo no existe el cliente o las categorías, cortamos acá
        if (!$cliente || $categorias->isEmpty()) {
            return;
        }

        // Solicitud 1: Pendiente de revisión
        $booking1 = Booking::create([
            'user_id'           => $cliente->id,
            'event_category_id' => $categorias->first()->id,
            'estimated_date'    => now()->addMonths(2)->format('Y-m-d'),
            'estimated_guests'  => 120,
            'ideas_or_details'  => 'Queremos una ambientación romántica en tonos pastel, flores blancas y luces cálidas para la recepción.',
            'status'            => 'pending',
        ]);

        // Vinculamos los primeros 2 servicios del catálogo (si existen)
        if ($servicios->count() >= 2) {
            $booking1->services()->attach($servicios->take(2)->pluck('id'));
        }

        // Solicitud 2: Ya presupuestada
        $booking2 = Booking::create([
            'user_id'           => $cliente->id,
            'event_category_id' => $categorias->last()->id,
            'estimated_date'    => now()->addMonths(4)->format('Y-m-d'),
            'estimated_guests'  => 80,
            'ideas_or_details'  => 'Cumpleaños de 15 estilo moderno con sector de fotos y livings cómodos para los chicos.',
            'status'            => 'budgeted',
        ]);

        // Vinculamos otros servicios
        if ($servicios->count() >= 3) {
            $booking2->services()->attach($servicios->slice(1, 2)->pluck('id'));
        }
    }
}
