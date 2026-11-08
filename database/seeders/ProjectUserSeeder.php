<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asignamos un usuario a un proyecto en la tabla pivote
        DB::table('project_user')->insert([
            'project_id' => 1, // El ID del proyecto que sembramos antes
            'user_id' => 1,    // El ID del usuario que sembramos antes
            'role' => 'Desarrollador', // El rol solicitado en la práctica
            'contribution_hours' => 10, // Las horas solicitadas en la práctica[cite: 9]
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
