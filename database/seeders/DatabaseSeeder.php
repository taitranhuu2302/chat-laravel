<?php

namespace Database\Seeders;

use App\Enums\FriendStatus;
use App\Models\Friend;
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
        $userOne = User::factory()->createOne([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'full_name' => 'Admin',
            'avatar' => 'https://picsum.photos/1200/800',
            'login_first' => false,
        ]);

        $userTwo = User::factory()->createOne([
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('password'),
            'full_name' => 'Admin Two',
            'avatar' => 'https://picsum.photos/1200/800',
            'login_first' => false,
        ]);

        Friend::factory()->createOne([
            'user_id' => $userOne->id,
            'friend_id' => $userTwo->id,
            'status' => FriendStatus::FRIEND,
        ]);

        Friend::factory()->createOne([
            'user_id' => $userTwo->id,
            'friend_id' => $userOne->id,
            'status' => FriendStatus::FRIEND,
        ]);
    }
}
