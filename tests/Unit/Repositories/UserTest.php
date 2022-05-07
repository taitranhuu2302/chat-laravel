<?php

namespace Tests\Unit\Repositories;

use App\Models\User;
use App\Repositories\Profile\ProfileRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use Faker\Factory as Faker;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->fake = Faker::create();
        $this->user = [
            'full_name' => $this->fake->name,
            'email' => $this->fake->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'avatar' => 'https://pics um.photos/1200/800',
        ];


        $this->userRepository = new UserRepository();
        $this->profileRepository = new ProfileRepository();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_create_user()
    {
        $user = $this->userRepository->create($this->user);
        $profile = $this->profileRepository->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($this->user['full_name'], $user['full_name']);
        $this->assertEquals($this->user['email'], $user['email']);
        $this->assertDatabaseHas('users', $this->user);
        $this->assertDatabaseHas('profiles', $profile->toArray());
    }

    public function test_find_user_by_id()
    {
        $user = User::factory()->create();
        $found = $this->userRepository->findById($user->id);

        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals($user->id, $found->id);
        $this->assertEquals($user->full_name, $found->full_name);
        $this->assertEquals($user->email, $found->email);
        $this->assertEquals($user->avatar, $found->avatar);
    }

    public function test_find_user_by_email()
    {
        $user = User::factory()->create();
        $found = $this->userRepository->findByEmail($user->email);

        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals($user->id, $found->id);
        $this->assertEquals($user->full_name, $found->full_name);
        $this->assertEquals($user->email, $found->email);
        $this->assertEquals($user->avatar, $found->avatar);
    }

    public function test_update_user()
    {
        $user = User::factory()->create();
        $updated = $this->userRepository->update($user->id, $this->user);

        $this->assertInstanceOf(User::class, $updated);
        $this->assertEquals($this->user['full_name'], $updated['full_name']);
        $this->assertEquals($this->user['email'], $updated['email']);
        $this->assertDatabaseHas('users', $updated->toArray());
    }

    public function test_delete_user()
    {
        $user = User::factory()->create();

        $userDelete = $this->userRepository->deleteById($user->id);

        $this->assertEquals(false, $userDelete['is_active']);
        $this->assertDatabaseHas('users', $userDelete->toArray());
    }

}
