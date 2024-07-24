<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            'Casación',
            'Primera Instancia',
            'Segunda Instancia'
        ];

        foreach ($estados as $estado) {
            Status::updateOrCreate(['name' => $estado]);
        }
    }
}
