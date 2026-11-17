<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creamos la cuenta de la decoradora administrador
        User::create([
            'name' => 'Decoradora Administradora',
            'email' => 'admin@simkus.com',
            'password' => Hash::make('admin1234'), // Contraseña encriptada segura
            'role'     => 'admin',
        ]);

         // Un cliente de prueba
         User::create([
            'name'     => 'Cliente de Prueba',
            'email'    => 'cliente@simkus.com',
            'password' => Hash::make('cliente1234'),
            'role'     => 'cliente',
            ]);
    }
}
