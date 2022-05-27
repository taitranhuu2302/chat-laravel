<?php

namespace Tests\Unit\Repositories;

use App\Enums\TaskStatus;
use App\Enums\TimeZone;
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

        $this->dueDate = Carbon::now(TimeZone::VIE)->addDays(1)->format('Y-m-d');
        $this->taskRepository = new TaskRepository();

        $this->userOne = User::factory()->create();
        $this->userTwo = User::factory()->create();

        $this->task = [
            'title' => 'Task 1',
            'content' => 'Task 1 description',
            'due_date' => $this->dueDate,
            'users' => [$this->userOne->id, $this->userTwo->id],
        ];
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_create_task()
    {
        $data = $this->task;
        $data['owner_id'] = $this->userOne->id;

        $task = $this->taskRepository->create($data);
        $task->load('users');

        $this->assertDatabaseHas('tasks', [
            'title' => 'Task 1',
            'content' => 'Task 1 description',
            'due_date' => $this->dueDate,
            'status' => TaskStatus::PENDING
        ]);
    }

    public function test_due_date_task()
    {

        $task = $this->taskRepository->create([
            'title' => 'Task 1',
            'content' => 'Task 1 description',
            'due_date' => Carbon::yesterday(),
            'users' => [$this->userOne->id, $this->userTwo->id],
            'owner_id' => $this->userOne->id
        ]);

        $this->artisan('task:due-date-task');
        $taskAfterUpdate = $this->taskRepository->findById($task->id);

        $this->assertEquals(TaskStatus::IN_COMPLETE, $taskAfterUpdate->status);
    }

    public function test_update_task()
    {
        $data = $this->task;
        $data['owner_id'] = $this->userOne->id;
        $task = $this->taskRepository->create($data);

        $task = $this->taskRepository->update($task->id, [
            'title' => 'Task 2',
            'content' => 'Task 2 description',
            'due_date' => Carbon::now(TimeZone::VIE)->addDays(2),
            'users' => [$this->userOne->id, $this->userTwo->id]
        ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Task 2',
            'content' => 'Task 2 description',
            'due_date' => Carbon::now(TimeZone::VIE)->addDays(2),
            'status' => TaskStatus::PENDING
        ]);

        $this->assertDatabaseHas('users_tasks', [
            'task_id' => $task->id,
            'user_id' => $this->userOne->id
        ]);

        $this->assertDatabaseHas('users_tasks', [
            'task_id' => $task->id,
            'user_id' => $this->userTwo->id
        ]);

        $this->taskRepository->findById($task->id);
        $this->assertEquals(2, $task->users->count());
    }
}
