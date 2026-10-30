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
            'description' => 'Ambientaciones románticas, alta florería, altares al aire libre y fondos de mesa principal.',
            'base_price' => 800000,
            'price_per_guest' => 6000,
        ],
        [
            'name' => 'Cumpleaños de 15',
            'description' => 'Decoraciones temáticas, livings modernos, túneles de luces LED y rincones instagrameables.',
            'base_price' => 600000,
            'price_per_guest' => 5000,
        ],
        [
            'name' => 'Cumpleaños Infantiles',
            'description' => 'Mesas dulces temáticas, arcos de globos orgánicos y fondos corpóreos personalizados.',
            'base_price' => 250000,
            'price_per_guest' => 2500,
        ],
        [
            'name' => 'Eventos Corporativos',
            'description' => 'Cenas de fin de año, ambientación de escenarios, stands de marcas y recepciones elegantes.',
            'base_price' => 500000,
            'price_per_guest' => 4000,
        ],
    ];

    foreach ($categories as $category) {
        EventCategory::create([
            'name' => $category['name'],
            'slug' => Str::slug($category['name']),
            'description' => $category['description'],
            'base_price' => $category['base_price'],
            'price_per_guest' => $category['price_per_guest'],
        ]);
    }
}
}
