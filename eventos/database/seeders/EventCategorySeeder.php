<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Bodas y Casamientos',
                'description' => 'Ambientaciones románticas, alta florería, altares al aire libre y fondos de mesa principal.'
            ],
            [
                'name' => 'Cumpleaños de 15',
                'description' => 'Decoraciones temáticas, livings modernos, túneles de luces LED y rincones instagrameables.'
            ],
            [
                'name' => 'Cumpleaños Infantiles',
                'description' => 'Mesas dulces temáticas, arcos de globos orgánicos y fondos corpóreos personalizados.'
            ],
            [
                'name' => 'Eventos Corporativos',
                'description' => 'Cenas de fin de año, ambientación de escenarios, stands de marcas y recepciones elegantes.'
            ],
        ];

        foreach ($categories as $category) {
            EventCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}
