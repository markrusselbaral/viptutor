<?php

namespace App\Repositories;

use App\Models\Task;
use Cache;

class TaskRepository implements TaskRepositoryInterface {

    public function getAll($userId, $filters)
    {
        // Create a unique cache key based on user and filters
        $cacheKey = 'tasks_user_' . $userId;

        // Cache for 5 minutes
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($userId, $filters) {
            return Task::where('user_id', $userId)
                ->filterStatus($filters['status'] ?? null)
                ->filterPriority($filters['priority'] ?? null)
                ->when($filters['search'] ?? null, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                    });
                })
                ->orderBy('order')
                ->get();
        });
    }


    public function totalTasks()
    {
        return Task::count();
    }

    public function pendingTasks()
    {
        return Task::where('status', 'pending')->count();
    }

    public function completedTasks()
    {
        return Task::where('status', 'completed')->count();
    }

    public function getById(int $id) {
        return Task::findOrFail($id);
    }

    public function create(array $data) {
        return Task::create($data);
    }

    public function update(int $id, int $userId, bool $isCompleted): Task
    {
        $status = '';
        if ($isCompleted) {
            $status = 'completed';
        } else {
            $status = 'pending';
        }
        $task = Task::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $task->update(['status' => $status]);
        return $task;
    }

    public function delete(string $id, string $userId): void
    {
        Task::where('id', $id)->where('user_id', $userId)->delete();
    }

    public function reorder(array $orders): void
    {
        foreach ($orders as $item) {
            Task::where('id', $item['id'])->update(['order' => $item['order']]);
        }
    }

}