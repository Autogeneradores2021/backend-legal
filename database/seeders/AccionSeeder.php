<?php

namespace Database\Seeders;

use App\Models\Action;
use Illuminate\Database\Seeder;

class AccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $acciones = [
            'Acción Popular',
            'Acumulado Contractual y Reparación Directa',
            'Controversias Contractuales',
            'Nulidad y Restablecimiento del Derecho',
            'Ordinario',
            'Reparación Directa',
        ];

        foreach ($acciones as $accion) {
            Action::updateOrCreate(['name' => $accion]);
        }

    }
}
