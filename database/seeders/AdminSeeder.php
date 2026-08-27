<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('users')->insert( [
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'address' => 'admin',
                'password' => Hash::make('password'),
                'phone' => '99999999'
           ]);

        DB::table('model_has_roles')->insert( [
                'role_id' => 1, // 1:admin
                'model_type' => 'App\Models\User',
                'model_id' => 1
        ]);        
    }
}
