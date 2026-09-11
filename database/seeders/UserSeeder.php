<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // agrega pacientes

        $ultimoId = DB::table('users')->insertGetId ( [
               'name' => 'Juan Carlos Salazar',
               'email' => 'juan.carlos.salazar@gmail.com',
               'password' => Hash::make('password'),
               'address' => 'Direccion Falsa 420',
               'phone' => '56998784512'
           ]);

        DB::table('patients')->insert( [
                'user_id' => $ultimoId,
                'blood_type_id' => 3,
                'allergies' => 'Polvo',
                'chronics_conditions' => 'NN',
                'observations' => 'Sin comentarios',
                'emergency_contact_name' => 'Contacto de Carlos Salazar'
        ]);

        // agrega role
        DB::table('model_has_roles')->insert( [
                'role_id' => 2, // 2:patient
                'model_type' => 'App\Models\User',
                'model_id' => $ultimoId
        ]);        


        $ultimoId =  DB::table('users')->insertGetId ( [
               'name' => 'Pedro Belmar',
               'email' => 'pedro.belmar@gmail.com',
               'password' => Hash::make('password'),
               'address' => 'Direccion Falsa 300',
               'phone' => '569887744'
           ]);

        DB::table('patients')->insert( [
                'user_id' => $ultimoId,
                'blood_type_id' => 3,
                'allergies' => 'Gluten',
                'chronics_conditions' => 'Insuf Renal',
                'observations' => 'Renato Titis',
                'emergency_contact_name' => 'Contacto sin tacto'
           ]);

        // agrega role
        DB::table('model_has_roles')->insert( [
                'role_id' => 2, // 2:patient
                'model_type' => 'App\Models\User',
                'model_id' => $ultimoId
        ]);        



        $ultimoId = DB::table('users')->insertGetId ( [
               'name' => 'Juan Pablo Escobar',
               'email' => 'juan.pablo.escobar@gmail.com',
               'password' => Hash::make('password'),
               'address' => 'Direccion Falsa 200',
               'phone' => '569887744'
           ]);

           DB::table('patients')->insert( [
                'user_id' => $ultimoId,
                'blood_type_id' => 1,
                'allergies' => 'Azucar',
                'chronics_conditions' => 'Insulino Dependiente',
                'observations' => 'Sucaritas Titis',
                'emergency_contact_name' => 'Contacto dulce'
           ]);

        // agrega role
        DB::table('model_has_roles')->insert( [
                'role_id' => 2, // 2:patient
                'model_type' => 'App\Models\User',
                'model_id' => $ultimoId
        ]);        


        $ultimoId = DB::table('users')->insertGetId ( [
               'name' => 'Eduardo Tapia',
               'email' => 'eduardo.tapia@gmail.com',
               'password' => Hash::make('password'),
               'address' => 'Direccion Falsa 410',
               'phone' => '569887744'
           ]);

           DB::table('patients')->insert( [
                'user_id' => $ultimoId,
                'blood_type_id' => 1,
                'allergies' => 'Alcohol',
                'chronics_conditions' => 'Alcoholicos anonimos',
                'observations' => 'Se lo chupa todo',
                'emergency_contact_name' => 'Contacto copete'
           ]);

        // agrega role
        DB::table('model_has_roles')->insert( [
                'role_id' => 2, // 2:patient
                'model_type' => 'App\Models\User',
                'model_id' => $ultimoId
        ]);        


         $ultimoId = DB::table('users')->insertGetId ( [
               'name' => 'Francisco Ramirez',
               'email' => 'francisco.ramirez@gmail.com',
               'password' => Hash::make('password'),
               'address' => 'Direccion Falsa 410',
               'phone' => '569887744'
           ]);

           DB::table('patients')->insert( [
                'user_id' => $ultimoId,
                'blood_type_id' => 1,
                'allergies' => 'Polvo',
                'chronics_conditions' => 'Polvos anonimos',
                'observations' => 'Nada de polvos',
                'emergency_contact_name' => 'Contacto empolvados'
           ]);

        // agrega role
        DB::table('model_has_roles')->insert( [
                'role_id' => 2, // 2:patient
                'model_type' => 'App\Models\User',
                'model_id' => $ultimoId
        ]);        
    }
}
