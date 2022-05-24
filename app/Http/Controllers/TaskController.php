<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\CreateTaskRequest;
use App\Repositories\Task\TaskRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    protected TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function createTask(CreateTaskRequest $request)
    {
        try {
            $data = $request->all();
            $data['owner_id'] = Auth::id();
            $data['status'] = TaskStatus::PENDING;
            $task = $this->taskRepository->create($data);

            return response()->json(['status' => 'success', 'message' => 'Task created successfully.', 'data' => $task], 200);
        } catch(\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
