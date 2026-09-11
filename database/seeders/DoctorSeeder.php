<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Doctores
        $ultimoId = DB::table('users')->insertGetId ( [
               'name' => 'Manuel Cardiopata',
               'email' => 'manuel.cardiopata@gmail.com',
               'password' => Hash::make('password'),
               'address' => 'Direccion Falsa 410',
               'phone' => '569887744'
        ]);

        DB::table('doctors')->insert( [
                'user_id' => $ultimoId,
                'speciality_id' => 3,    // Cardiologo
                'medical_license_number' => '0303456',
                'active' => 1
        ]);

        // agrega role
        DB::table('model_has_roles')->insert( [
                'role_id' => 3, // 3: Doctor
                'model_type' => 'App\Models\User',
                'model_id' => $ultimoId
        ]);        

        //
        $ultimoId = DB::table('users')->insertGetId ( [
               'name' => 'Oscar Perez',
               'email' => 'oscar.perez@gmail.com',
               'password' => Hash::make('password'),
               'address' => 'Direccion Falsa Perez 410',
               'phone' => '569887744'
        ]);

        DB::table('doctors')->insert( [
                'user_id' => $ultimoId,
                'speciality_id' => 1,  // Medicina General
                'medical_license_number' => '500500',
                'active' => 1
        ]);

        // agrega role
        DB::table('model_has_roles')->insert( [
                'role_id' => 3, // 3: Doctor
                'model_type' => 'App\Models\User',
                'model_id' => $ultimoId
        ]);        


        //
        $ultimoId = DB::table('users')->insertGetId ( [
               'name' => 'Pedro Opazo',
               'email' => 'pedro.opazo@gmail.com',
               'password' => Hash::make('password'),
               'address' => 'Direccion Falsa Opazo 410',
               'phone' => '569887744'
        ]);

        DB::table('doctors')->insert( [
               'user_id' => $ultimoId,
               'speciality_id' => 5,   // Oftalmologia 
               'medical_license_number' => '600600',
               'active' => 1
        ]);

        // agrega role
        DB::table('model_has_roles')->insert( [
                'role_id' => 3, // 3: Doctor
                'model_type' => 'App\Models\User',
                'model_id' => $ultimoId
        ]);        



        $ultimoId = DB::table('users')->insertGetId ( [
               'name' => 'Juan Gine Cologo',
               'email' => 'juan.gine.cologo@gmail.com',
               'password' => Hash::make('password'),
               'address' => 'Direccion Falsa Gine Cologo 410',
               'phone' => '569887744'
        ]);

        DB::table('doctors')->insert( [
                'user_id' => $ultimoId,
                'speciality_id' => 2,   // Ginecología
                'medical_license_number' => '700700',
                'active' => 1
        ]);

        // agrega role
        DB::table('model_has_roles')->insert( [
                'role_id' => 3, // 3: Doctor
                'model_type' => 'App\Models\User',
                'model_id' => $ultimoId
        ]);        

        

        $ultimoId = DB::table('users')->insertGetId ( [
               'name' => 'Mario Obste Tra',
               'email' => 'mario.obste.tra@gmail.com',
               'password' => Hash::make('password'),
               'address' => 'Direccion Falsa Obste Tra 410',
               'phone' => '569887744'
        ]);

        DB::table('doctors')->insert( [
                'user_id' => $ultimoId,
                'speciality_id' => 4,   // Obstetra
                'medical_license_number' => '800800',
                'active' => 1
        ]);

        // agrega role
        DB::table('model_has_roles')->insert( [
                'role_id' => 3, // 3: Doctor
                'model_type' => 'App\Models\User',
                'model_id' => $ultimoId
        ]);     

    }
}
