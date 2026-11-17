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
            ['name' => 'Mesa dulce temática',     'description' => 'Tortas, cupcakes y golosinas decoradas', 'price' => 120000],
            ['name' => 'Iluminación LED',         'description' => 'Luces cálidas, guirnaldas y tachos LED', 'price' => 90000],
            ['name' => 'Fotógrafo profesional',   'description' => 'Cobertura completa del evento',          'price' => 150000],
            ['name' => 'Arco de globos orgánico', 'description' => 'Arco de globos en la paleta del evento', 'price' => 60000],
            ['name' => 'Living lounge',           'description' => 'Sillones, mesas ratonas y alfombras',    'price' => 110000],
        ];
        
        foreach ($services as $service) {
            Service::create($service);
            }
        }
}
