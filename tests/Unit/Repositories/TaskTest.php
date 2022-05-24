<?php

namespace Tests\Unit\Repositories;

use App\Enums\TaskStatus;
use App\Models\User;
use App\Repositories\Task\TaskRepository;
use Carbon\Carbon;
use Tests\TestCase;

class TaskTest extends TestCase
{
    public $userOne;
    public $userTwo;
    public $task;
    public $dueDate;


    public function setUp(): void
    {
        parent::setUp();

        $this->dueDate = Carbon::now()->addDays(1)->format('Y-m-d');
        $this->taskRepository = new TaskRepository();

        $this->userOne = User::factory()->create();
        $this->userTwo = User::factory()->create();

        $this->task = [
            'title' => 'Task 1',
            'description' => 'Task 1 description',
            'due_date' => $this->dueDate,
        ];
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_create_task()
    {
        $task = $this->taskRepository->create($this->task);

        $task = $this->taskRepository->addUserToTask($task->id, [$this->userOne->id, $this->userTwo->id]);
        $task->load('users');

        $this->assertDatabaseHas('tasks', [
            'title' => 'Task 1',
            'description' => 'Task 1 description',
            'due_date' => $this->dueDate,
            'status' => TaskStatus::PENDING
        ]);
    }

    public function test_due_date_task()
    {
        $task = $this->taskRepository->create([
            'title' => 'Task 1',
            'description' => 'Task 1 description',
            'due_date' => Carbon::now(),
        ]);
        $task = $this->taskRepository->addUserToTask($task->id, [$this->userOne->id, $this->userTwo->id]);


    }
}
