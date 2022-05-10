<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->createOne([
           'email' => 'admin@gmail.com',
           'password' => Hash::make('password'),
           'full_name' => 'Admin',
           'avatar' => 'https://picsum.photos/1200/800',
        ]);
    }
}
