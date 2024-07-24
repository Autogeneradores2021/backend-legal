<?php

namespace Database\Seeders;

use App\Models\FailurePossibility;
use Illuminate\Database\Seeder;

class PosibilidadFalloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posibilidades = [
            'Alta',
        ];

        foreach ($posibilidades as $posibilidad) {
            FailurePossibility::updateOrCreate(['name' => $posibilidad]);
        }
    }
}
