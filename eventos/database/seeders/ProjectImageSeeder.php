<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectImageSeeder extends Seeder
{
    public function run(): void
    {
        // slug del proyecto => sus fotos
        $galerias = [
            'boda-de-goku-y-milk' => [
                ['image_path' => 'projects/galeria/boda-gokumilk-1.jpeg', 'descripcion' => 'Vista general de la ambientación'],
                ['image_path' => 'projects/galeria/boda-gokumilk-2.jpeg', 'descripcion' => 'Detalle de la decoración'],
                ['image_path' => 'projects/galeria/boda-gokumilk-3.jpeg', 'descripcion' => null],
                ['image_path' => 'projects/galeria/boda-gokumilk-4.jpeg', 'descripcion' => null],
            ],
        ];

        foreach ($galerias as $slug => $fotos) {
            $project = Project::where('slug', $slug)->first();

            foreach ($fotos as $foto) {
                $project->images()->create($foto);
            }
        }
    }
}