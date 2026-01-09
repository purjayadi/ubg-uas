<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Restaurant;
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
        // Create Admin User if not exists
        if (!User::where('email', 'admin@gmail.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]);
        }

        // Create Regular User if not exists
        if (!User::where('email', 'test@example.com')->exists()) {
            User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ]);
        }

        // Create Test Restaurant if not exists
        if (Restaurant::where('name', 'Nasi Kuning Enak')->doesntExist()) {
            Restaurant::create([
                'name' => 'Nasi Kuning Enak',
                'description' => 'Restoran dengan nasi kuning tradisional yang lezat dan gurih. Bahan-bahan pilihan dimasak dengan bumbu rempah yang sempurna.',
                'address' => 'Jl. Merdeka No. 123, Jakarta Pusat',
                'phone' => '021-1234567',
                'cuisine_type' => 'Indonesian',
                'image' => 'restaurants/test_nasi_kuning.jpg',
                'rating' => 0,
            ]);
        }
    }
}
