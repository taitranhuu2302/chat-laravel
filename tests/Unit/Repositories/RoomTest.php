<?php

namespace Tests\Unit\Repositories;

use App\Enums\RoomType;
use App\Models\Room;
use App\Models\User;
use App\Repositories\Room\RoomRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Str;
use Tests\TestCase;

class RoomTest extends TestCase
{
    private $user;
    private User $userOne;
    private User $userTwo;
    private Room $roomGroup;
    private Room $roomPrivate;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = [
            'full_name' => 'John Doe',
            'email' => Str::random(16) . '@gmail.com',
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

    public function test_create_group_room()
    {
        $this->userOne = $this->userRepository->create($this->user);
        $this->userTwo = $this->userRepository->create($this->user);

        $this->roomGroup = $this->roomRepository->create([
            'name' => 'Group Room',
            'room_type' => RoomType::GROUP_ROOM,
            'owner_id' => $this->userOne->id,
            'description' => 'Group Room Description',
        ]);
        $this->roomRepository->addUserToRoom($this->roomGroup->id, $this->userOne->id);
        $this->roomRepository->addUserToRoom($this->roomGroup->id, $this->userTwo->id);

        $this->assertEquals('Group Room', $this->roomGroup->name);
        $this->assertEquals(RoomType::GROUP_ROOM, $this->roomGroup->room_type);
        $this->assertEquals($this->userOne->id, $this->roomGroup->owner_id);
        $this->assertEquals('Group Room Description', $this->roomGroup->description);
        $this->assertEquals(2, $this->roomGroup->users()->count());
    }
}
