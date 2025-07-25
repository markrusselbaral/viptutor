<?php

namespace App\Services;

use App\Repositories\TaskRepositoryInterface;

class TaskService {

    public function __construct(protected TaskRepositoryInterface $TaskRepository) {}

    public function getAll($userId, $filters = []) {
        return $this->TaskRepository->getAll($userId, $filters);
    }

    public function getById(int $id) {
        return $this->TaskRepository->getById($id);
    }

    public function create(array $data) {
        return $this->TaskRepository->create($data);
    }

    public function update(int $id, int $userId, bool $isCompleted) {
        return $this->TaskRepository->update($id, $userId, $isCompleted);
    }

   public function delete(string $id, string $userId) {
        return $this->TaskRepository->delete($id, $userId);
    }

    public function reorderTasks(array $orders)
    {
        return $this->TaskRepository->reorder($orders);
    }

    public function totalTasks()
    {
        return $this->TaskRepository->totalTasks();
    }

    public function pendingTasks()
    {
        return $this->TaskRepository->pendingTasks();
    }

    public function completedTasks()
    {
        return $this->TaskRepository->completedTasks();
    }
}