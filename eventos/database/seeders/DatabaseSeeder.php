<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llamamos al seeder de categorías para que cree Bodas, 15 Años, etc.
        $this->call([
            EventCategorySeeder::class,
            ProjectSeeder::class,
            ProjectImageSeeder::class,
        ]);
    }
}
