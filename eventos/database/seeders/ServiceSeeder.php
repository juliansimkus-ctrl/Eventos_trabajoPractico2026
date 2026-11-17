<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    {
        $services = [
            ['name' => 'Mesa principal completa',     'description' => 'Decoracion mesa principal', 'price' => 200000],
            ['name' => 'Candy bar',         'description' => 'Bar para una x cantidad de personas, indicar en comentario', 'price' => 150000],
            ['name' => 'Sector solo torta',   'description' => 'Mesa dedicada unicamente a la presentacion de la torta', 'price' => 110000],
            ['name' => 'Arco de globos orgánico', 'description' => 'Arco de globos en la paleta del evento', 'price' => 90000],
            ['name' => 'Rincon fotos completo', 'description' => 'Sillones, mesas ratonas y alfombras',    'price' => 170000],
            ['name' => 'Rincon fotos simple', 'description' => 'Sillones, decoracion minima',    'price' => 110000],
            ['name' => 'Regalos para invitados', 'description' => 'Regalos personalizados para los invitados',    'price' => 190000],
            ['name' => 'Libro de firmas', 'description' => 'Tripode con un libro de firmas personalizado',    'price' => 70000],
            ['name' => 'Designacion de mesas', 'description' => 'Nos encargamos de la designacion de mesas',    'price' => 60000],
            ['name' => 'Kit SOS resaca', 'description' => 'Se entrega luego de la fiesta a los invitados, (el precio depende de los invitados)',    'price' => 130000],
            ['name' => 'Kit SOS hombre y mujer', 'description' => 'Se da a los invitados durante el evento, (el precio depende de los invitados)',    'price' => 130000],
        ];
        
        foreach ($services as $service) {
            Service::create($service);
            }
        }
}
