<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Http\Requests\TaskRequest;
use Cache;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService) {}

    public function index(Request $request): JsonResponse
    {
        $userId = $request->user()->id;
        $filters = $request->only(['status', 'priority', 'search']);

        $tasks = $this->taskService->getAll($userId, $filters);
        Cache::forget('tasks_user_' . $request->user()->id);
        return response()->json($tasks);
    }

    public function store(TaskRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $task = $this->taskService->create($data);
        Cache::forget('tasks_user_' . $request->user()->id);
        return response()->json($task, 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $isCompleted = $request->isCompleted;
        $task = $this->taskService->update($id, $request->user()->id, $isCompleted);
        Cache::forget('tasks_user_' . $request->user()->id);
        return response()->json($task);
    }

    public function destroy(int $id, Request $request): JsonResponse
    {
        $this->taskService->delete($id, auth()->id());
        Cache::forget('tasks_user_' . $request->user()->id);
        return response()->json(['message' => 'Task deleted successfully']);
    }

    public function reorder(Request $request): JsonResponse
    {
        $this->taskService->reorderTasks($request->order);
        Cache::forget('tasks_user_' . $request->user()->id);
        return response()->json(['message' => 'Tasks reordered successfully']);
    }

}
