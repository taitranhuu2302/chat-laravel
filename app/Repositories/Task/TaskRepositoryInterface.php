<?php

namespace App\Repositories\Task;

use App\Repositories\RepositoryInterface;

interface TaskRepositoryInterface extends RepositoryInterface
{
    public function addUserToTask($taskId, $users);
}
