<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

       DB::statement('SET FOREIGN_KEY_CHECKS=0;');
       
       DB::table('users')->truncate();
       DB::table('doctors')->truncate();
       DB::table('schedules')->truncate();
       DB::table('patients')->truncate();
       DB::table('model_has_roles')->truncate();

       DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call(AdminSeeder::class);
        $this->call(PatientSeeder::class);
        $this->call(DoctorSeeder::class);
   

        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        */
        //$this->call(ProductoSeeder::class);
        //$this->call( RoleSeeder::class);
        //$this->call( BloodTypeSeeder::class);
        /*
        User::factory()->create([
            'name' => 'Carlos Santa',
            'email' => 'carlos@example.com',
            'password' => bcrypt('12345678')
        ]);
*/

    }
}
