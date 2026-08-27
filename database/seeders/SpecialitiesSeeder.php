<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $specialities = [
            'Medicina General',
            'Ginecologo',
            'Cardiologo',
            'Obstetra',
            'Oftalmologo'
        ];
        foreach ($specialities as $speciality) {
            \App\Models\Speciality::create(['name' => $speciality]);
        }       
    }
}
