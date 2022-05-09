<?php

namespace Tests\Unit\Repositories;

use App\Enums\RoomType;
use App\Models\Room;
use App\Models\User;
use App\Repositories\Room\RoomRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Tests\TestCase;

class RoomTest extends TestCase
{
    use RefreshDatabase;
    private array $userOne;
    private array $userTwo;

    public function setUp(): void
    {
        parent::setUp();

        $this->userOne = [
            'full_name' => 'John Doe',
            'email' => Str::random(16) . '@gmail.com',
            'password' => '$2y$10$8eDRebj2f8uBJ0gMUbBSv.3QXRCUYkuGzW0HSUfmxP/xhyGQFkl2.',
            'avatar' => 'https://pics um.photos/1200/800',
        ];

        $this->userTwo = [
            'full_name' => 'Jane Doe',
            'email' => Str::random(10) . '@gmail.com',
            'password' => '$2y$10$8eDRebj2f8uBJ0gMUbBSv.3QXRCUYkuGzW0HSUfmxP/xhyGQFkl2.',
            'avatar' => 'https://pics um.photos/1200/800',
        ];

        $this->userRepository = new UserRepository();
        $this->roomRepository = new RoomRepository();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_create_group()
    {
        $userOne = $this->userRepository->create($this->userOne);
        $userTwo = $this->userRepository->create($this->userTwo);

        $roomGroup = $this->roomRepository->create([
            'name' => 'Group Room',
            'room_type' => RoomType::GROUP_ROOM,
            'owner_id' => $userOne->id,
            'description' => 'Group Room Description',
        ]);
        $this->roomRepository->addUserToRoom($roomGroup->id, $userOne->id);
        $this->roomRepository->addUserToRoom($roomGroup->id, $userTwo->id);

        $this->assertEquals('Group Room', $roomGroup->name);
        $this->assertEquals(RoomType::GROUP_ROOM, $roomGroup->room_type);
        $this->assertEquals($userOne->id, $roomGroup->owner_id);
        $this->assertEquals('Group Room Description', $roomGroup->description);
        $this->assertEquals(2, $roomGroup->users()->count());
    }

    public function test_create_private_room()
    {
        $userOne = $this->userRepository->create($this->userOne);
        $userTwo = $this->userRepository->create($this->userTwo);

        $roomPrivate = $this->roomRepository->create([
            'room_type' => RoomType::PRIVATE_ROOM,
        ]);

        $roomPrivate = $this->roomRepository->addUserToRoom($roomPrivate->id, $userOne->id);
        $roomPrivate = $this->roomRepository->addUserToRoom($roomPrivate->id, $userTwo->id);

        $this->assertEquals(RoomType::PRIVATE_ROOM, $roomPrivate->room_type);
        $this->assertEquals(2, $roomPrivate->users()->count());
    }

    public function test_room_private_return_null_if_member_greater_two()
    {
        $userOne = $this->userRepository->create($this->userOne);
        $userTwo = $this->userRepository->create($this->userTwo);
        $userThree = $this->userRepository->create([
            'full_name' => 'John Doe',
            'email' => Str::random(10) . '@gmail.com',
            'password' => '$2y$10$8eDRebj2f8uBJ0gMUbBSv.3QXRCUYkuGzW0HSUfmxP/xhyGQFkl2.',
        ]);

        $roomPrivate = $this->roomRepository->create([
            'room_type' => RoomType::PRIVATE_ROOM,
        ]);

        $roomPrivate = $this->roomRepository->addUserToRoom($roomPrivate->id, $userOne->id);
        $roomPrivate = $this->roomRepository->addUserToRoom($roomPrivate->id, $userTwo->id);
        $this->assertEquals(2, $roomPrivate->users()->count());

        $roomPrivate = $this->roomRepository->addUserToRoom($roomPrivate->id, $userThree->id);

        $this->assertNull($roomPrivate);
    }

    public function test_return_null_if_add_member_exists_in_room()
    {
        $userOne = $this->userRepository->create($this->userOne);
        $userTwo = $this->userRepository->create($this->userTwo);

        $roomGroup = $this->roomRepository->create([
            'name' => 'Group Room',
            'room_type' => RoomType::GROUP_ROOM,
            'owner_id' => $userOne->id,
            'description' => 'Group Room Description',
        ]);

        $roomGroup = $this->roomRepository->addUserToRoom($roomGroup->id, $userOne->id);
        $roomGroup = $this->roomRepository->addUserToRoom($roomGroup->id, $userTwo->id);

        $this->assertNotNull($roomGroup);
        $this->assertEquals(2, $roomGroup->users()->count());

        $roomGroup = $this->roomRepository->addUserToRoom($roomGroup->id, $userTwo->id);
        $this->assertNull($roomGroup);
    }

    public function test_remove_member_from_room()
    {
        $userOne = $this->userRepository->create($this->userOne);
        $userTwo = $this->userRepository->create($this->userTwo);

        $roomGroup = $this->roomRepository->create([
            'name' => 'Group Room',
            'room_type' => RoomType::GROUP_ROOM,
            'owner_id' => $userOne->id,
            'description' => 'Group Room Description',
        ]);

        $roomGroup = $this->roomRepository->addUserToRoom($roomGroup->id, $userOne->id);
        $roomGroup = $this->roomRepository->addUserToRoom($roomGroup->id, $userTwo->id);

        $this->assertNotNull($roomGroup);
        $this->assertEquals(2, $roomGroup->users()->count());

        $roomGroup = $this->roomRepository->removeUserFromRoom($roomGroup->id, $userTwo->id);

        $this->assertNotNull($roomGroup);
        $this->assertEquals(1, $roomGroup->users()->count());
    }
}
