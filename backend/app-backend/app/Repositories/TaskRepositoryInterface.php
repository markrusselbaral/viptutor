<?php

namespace App\Repositories;

interface TaskRepositoryInterface {
    public function getAll(int $userId, array $filters);
    public function getById(int $id);
    public function create(array $data);
    public function update(int $id, int $userId, bool $isCompleted);
    public function delete(string $id, string $userId);
    public function reorder(array $orders);
    public function totalTasks();
    public function pendingTasks();
    public function completedTasks();
}