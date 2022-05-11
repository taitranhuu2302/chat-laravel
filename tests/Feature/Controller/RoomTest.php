<?php

namespace Tests\Feature\Controller;

use App\Enums\RoomType;
use App\Models\User;
use App\Repositories\Room\RoomRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class RoomTest extends TestCase
{

    use WithoutMiddleware;

    public function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();
        $this->roomRepository = new RoomRepository();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_get_all_room()
    {
        $response = $this->get('/room');

        $response->assertStatus(200);
    }

    public function test_create_group()
    {
        $user = User::factory()->create();
        $userOne = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => 'test',
            'room_type' => RoomType::GROUP_ROOM,
            'description' => 'test',
            'members' => [$userOne->id]
        ];

        $response = $this->json('POST', '/room/create-room-group', $data);

        $response->assertStatus(200);
    }

    public function test_show_room_by_id()
    {
        $user = User::factory()->create();
        $userOne = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => 'test',
            'room_type' => RoomType::GROUP_ROOM,
            'description' => 'test',
            'members' => [$userOne->id]
        ];

        $room = $this->roomRepository->create($data);
        $this->roomRepository->addUserToRoom($room->id, $user->id);
        $this->roomRepository->addUserToRoom($room->id, $userOne->id);

        $response = $this->get('/room/' . $room->id);

        $response->assertStatus(200);
        $response->assertViewIs('pages.room');
        $response->assertSee($room->name);
    }
}
