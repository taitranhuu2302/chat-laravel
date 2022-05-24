<?php

namespace App\Repositories\Task;

use App\Models\Task;
use App\Repositories\BaseRepository;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{

    public function getModel(): string
    {
        return Task::class;
    }

    public function create($attributes = [])
    {
        $users = $attributes['users'];

        unset($attributes['users']);
        $task = $this->model->create($attributes);

        $task->users()->attach($attributes['owner_id']);
        if ($users) {
            foreach ($users as $user) {
                $task->users()->attach($user);
            }
        }

        return $task;
    }

    /**
     * @param $taskId
     * @param $users (array of user ids)
     */
    public function addUserToTask($taskId, $users)
    {
        $task = $this->model->findOrFail($taskId);

        if (!$task) return null;
        foreach ($users as $user) {
            $task->users()->attach($user);
        }

        return $task;
    }
}
