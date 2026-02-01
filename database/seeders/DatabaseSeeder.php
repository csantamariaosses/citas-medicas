<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        */
        //$this->call(ProductoSeeder::class);
        //$this->call( RoleSeeder::class);
        $this->call( BloodTypeSeeder::class);
        /*
        User::factory()->create([
            'name' => 'Carlos Santa',
            'email' => 'carlos@example.com',
            'password' => bcrypt('12345678')
        ]);
*/

    }
}
