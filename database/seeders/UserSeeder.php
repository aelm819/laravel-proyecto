<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Necesario para usar la clase DB
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Opcional: Vacía la tabla antes de rellenarla para no duplicar datos
        // DB::table('users')->truncate();

        // Insertamos un usuario de prueba
        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password123'),
        ]);

        // Puedes copiar y pegar el bloque insert() para añadir más usuarios
    }
}
