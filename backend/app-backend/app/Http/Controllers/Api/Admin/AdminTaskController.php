<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\TaskService;
use App\Http\Requests\TaskRequest;

class AdminTaskController extends Controller
{
    public function __construct(
        protected UserService $userService, 
        protected TaskService $taskService) 
    {}

    public function index(): JsonResponse
    {
        $perPage = 10;

        $counts = $this->statistics();
        $users = $this->userService->getAll($perPage);

        return response()->json(['users' => $users, 'counts' => $counts]);
    }

    public function statistics()
    {
        $counts = [
            'totalUsers' => $this->userService->totalUsers(),
            'totaltasks' => $this->taskService->totalTasks(),
            'pendingtasks' => $this->taskService->pendingTasks(),
            'completedtasks' => $this->taskService->completedTasks()
        ];
        return $counts;
    }

}
