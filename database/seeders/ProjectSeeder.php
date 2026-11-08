<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insertamos un proyecto de prueba
        DB::table('projects')->insert([
            'title' => 'Plataforma de Gestión',
            'description' => 'Desarrollo de la nueva intranet colaborativa.',
            'deadline' => '2024-12-31',
            'status' => 'En progreso',
            'user_id' => 1, // ⚠️ Asignamos el ID del usuario "Administrador" que creamos antes
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Puedes añadir más bloques insert() aquí si quieres más proyectos
    }
}
