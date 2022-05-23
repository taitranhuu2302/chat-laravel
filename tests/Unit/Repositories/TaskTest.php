<?php

namespace Tests\Unit\Repositories;

use App\Models\User;
use App\Repositories\Task\TaskRepository;
use Carbon\Carbon;
use Tests\TestCase;

class TaskTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

        $this->taskRepository = new TaskRepository();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_create_task()
    {
        $userOne = User::factory()->create();
        $userTwo = User::factory()->create();

        $task = $this->taskRepository->create([
            'title' => 'Task 1',
            'description' => 'Task 1 description',
            'due_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
        ]);

        $task = $this->taskRepository->addUserToTask($task->id, [$userOne->id, $userTwo->id]);
        $task->load('users');
//        $this->assertDatabaseHas('tasks', [
//            'title' => 'Task 1',
//            'description' => 'Task 1 description',
//            'due_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
//        ]);

        dd($task->toArray());
    }
}
