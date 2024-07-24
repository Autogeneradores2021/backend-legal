<?php

namespace Database\Seeders;

use App\Models\ClassProcces;
use Illuminate\Database\Seeder;

class ClaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clases = [
            'Administrativo',
            'Constitucional',
            'Laboral'
        ];

        foreach ($clases as $clase) {
            ClassProcces::updateOrCreate(['name' => $clase]);
        }
    }
}
