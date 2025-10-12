<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        $this->call([
            AuthorsTableSeeder::class,
            BooksTableSeeder::class,
        ]);

        // Nii loetakse .env failist väärtusi
        $name  = env('ADMIN_NAME', 'Admin');
        $email = env('ADMIN_EMAIL');
        $pass  = env('ADMIN_PASSWORD');

        if ($email && $pass) {
            User::updateOrCreate(
                ['email' => $email],
                ['name' => $name, 'password' => Hash::make($pass)]
            );
        }
    }
}
