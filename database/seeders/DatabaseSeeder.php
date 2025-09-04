<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'leo',
            'email' => 'leogobalbi2gmail.com',
            'username' => 'leo',
            'password' => sha1(md5('********')), // Compatível com sistema original
            'status' => 'active',
        ]);
    }
}
