<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'category'    => 'bodas-y-casamientos',
                'title'       => 'Boda de Goku y Milk',
                'description' => 'Boda realizada al aire libre, en un lugar natural.',
                'image'       => 'projects/goku-mil-casamiento.jfif',
                'location'    => 'Chacra El Ceibo',
                'event_date'  => '2026-06-20',
                'is_featured' => true,
            ],
            [
                'category'    => 'cumpleanos-de-15',
                'title'       => 'Quince de Martina, temática París',
                'description' => 'Living en tonos rosa y dorado, torre Eiffel de luces y rincón para fotos.',
                'image'       => 'projects/cumple-lulu.jfif',
                'location'    => 'Salón Los Álamos',
                'event_date'  => '2026-09-14',
                'is_featured' => true,
            ],
            [
                'category'    => 'cumpleanos-infantiles',
                'title'       => 'Cumple de Tomi, dinosaurios',
                'description' => 'Mesa dulce temática, arco de globos verdes y fondo con volcán.',
                'image'       => 'projects/cumpleanios-infantil.jfif',
                'location'    => 'Pelotero Jumping',
                'event_date'  => '2026-08-02',
                'is_featured' => false,
            ],
            [
                'category'    => 'eventos-corporativos',
                'title'       => 'Cena de fin de año empresarial',
                'description' => 'Centros de mesa elegantes, iluminación cálida y escenario para el brindis.',
                'image'       => 'projects/charla-corporativa.jfif',
                'location'    => 'Hotel del Comahue',
                'event_date'  => '2025-12-15',
                'is_featured' => false,
            ],
        ];

        foreach ($projects as $data) {
            // Buscamos la categoría por su slug para obtener su id
            $category = EventCategory::where('slug', $data['category'])->first();

            Project::create([
                'event_category_id' => $category->id,
                'title'             => $data['title'],
                'slug'              => Str::slug($data['title']),
                'description'       => $data['description'],
                'image'             => $data['image'],
                'location'          => $data['location'],
                'event_date'        => $data['event_date'],
                'is_featured'       => $data['is_featured'],
            ]);
        }
    }
}