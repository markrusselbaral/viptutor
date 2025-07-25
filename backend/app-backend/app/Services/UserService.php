<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;

class UserService {

    public function __construct(protected UserRepositoryInterface $UserRepository) {}

    public function getAll(int $perPage) {
        return $this->UserRepository->getAll($perPage);
    }

    public function getById(int $id) {
        return $this->UserRepository->getById($id);
    }

    public function create(array $data) {
        return $this->UserRepository->create($data);
    }

    public function update(int $id, array $data) {
        return $this->UserRepository->update($id, $data);
    }

    public function delete(int $id) {
        return $this->UserRepository->delete($id);
    }

    public function totalUsers() 
    {
        return $this->UserRepository->totalUsers();
    }
}