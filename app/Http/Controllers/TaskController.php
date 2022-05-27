<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Repositories\Task\TaskRepositoryInterface;
use Illuminate\Http\JsonResponse;
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

    public function createTask(CreateTaskRequest $request): JsonResponse
    {
        try {
            $data = $request->all();
            $data['owner_id'] = Auth::id();
            $data['status'] = TaskStatus::PENDING;
            $task = $this->taskRepository->create($data);
            $task->load('owner');

            return response()->json(['status' => 'success', 'message' => 'Task created successfully.', 'data' => $task], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateTask(UpdateTaskRequest $request, $id): JsonResponse
    {
        try {
            $data = $request->all();
            $task = $this->taskRepository->findById($id);

            if ($task->owner_id != Auth::id()) {
                return response()->json(['status' => 'error', 'message' => 'You are not authorized to update this task.'], 401);
            }

            $task = $this->taskRepository->update($id, $data);
            $task->load('owner');
            $task->load('users');

            return response()->json(['status' => 'success', 'message' => 'Task updated successfully.', 'data' => $task], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteTask($id): JsonResponse
    {
        try {
            $task = $this->taskRepository->findById($id);

            if (!$task) {
                return response()->json(['status' => 'error', 'message' => 'Task not found.'], 404);
            }

            $this->taskRepository->delete($id);

            return response()->json(['status' => 'success', 'message' => 'Task deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
