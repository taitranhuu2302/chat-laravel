<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\CreateTaskRequest;
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

    public function createTask(CreateTaskRequest $request)
    {
        try {
            $data = $request->all();
            $data['owner_id'] = Auth::id();
            $data['status'] = TaskStatus::PENDING;
            $task = $this->taskRepository->create($data);
            $task->load('owner');

            return response()->json(['status' => 'success', 'message' => 'Task created successfully.', 'data' => $task], 200);
        } catch(\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteTask(Request $request, $id): JsonResponse
    {
        try {
            $task = $this->taskRepository->findById($id);

            if (!$task) {
                return response()->json(['status' => 'error', 'message' => 'Task not found.'], 404);
            }

            $this->taskRepository->delete($id);

            return response()->json(['status' => 'success', 'message' => 'Task deleted successfully.'], 200);
        } catch(\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
