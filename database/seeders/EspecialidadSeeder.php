<?php

namespace Database\Seeders;
use App\Models\Especialidad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EspecialidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $especialidades = [
                ['tipo' => 'Cardiología'],
                ['tipo' => 'Dermatología'],
                ['tipo' => 'Gastroenterología'],
                ['tipo' => 'Neurología'],
                ['tipo' => 'Pediatría']
            ];
    
            foreach ($especialidades as $especialidad) {
                Especialidad::create($especialidad);
            }
        }
    }
}