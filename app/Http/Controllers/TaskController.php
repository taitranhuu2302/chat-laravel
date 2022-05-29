<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Events\CreateTaskEvent;
use App\Events\UpdateTaskEvent;
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
            $task->load('users');

            if (isset($data['users'])) {
                foreach ($data['users'] as $user) {
                    event(new CreateTaskEvent($user, $task));
                }
            }

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

            $data['owner_id'] = Auth::id();
            $task = $this->taskRepository->update($id, $data);
            $task->load('owner');
            $task->load('users');

            if (isset($task->users)) {
                foreach ($task->users as $user) {
                    Log::info($user->id);
                    event(new UpdateTaskEvent($user->id, $task));
                }
            }

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

            if ($task->owner_id !== Auth::id()) {
                $task->users()->detach(Auth::id());
                return response()->json(['status' => 'success', 'message' => 'Bạn đã từ chối công việc thành công'], 200);
            }

            $this->taskRepository->delete($id);

            return response()->json(['status' => 'success', 'message' => 'Công việc đã được xoá'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
