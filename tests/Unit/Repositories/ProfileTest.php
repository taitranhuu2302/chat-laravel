<?php

namespace Tests\Unit\Repositories;

use App\Repositories\Profile\ProfileRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Faker\Factory as Faker;

class ProfileTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $profile;
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

    public function test_update_profile()
    {
        $user = $this->userRepository->create($this->user);

        $data = [
            'phone' => $this->fake->phoneNumber,
            'address' => $this->fake->address,
            'country' => $this->fake->country,
            'city' => $this->fake->city,
            'postal_code' => $this->fake->postcode,
            'about_myself' => $this->fake->sentence,
            'work' => $this->fake->sentence,
        ];

        $profile = $this->profileRepository->updateByUserId($user->id, $data);

        $this->assertEquals($data['phone'], $profile->phone);
        $this->assertEquals($data['address'], $profile->address);
        $this->assertEquals($data['country'], $profile->country);
        $this->assertEquals($data['city'], $profile->city);
        $this->assertEquals($data['postal_code'], $profile->postal_code);
        $this->assertEquals($data['about_myself'], $profile->about_myself);

        $this->assertDatabaseHas('profiles', $profile->toArray());
    }
}
