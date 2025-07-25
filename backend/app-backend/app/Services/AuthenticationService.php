<?php

namespace App\Services;

use App\Repositories\AuthenticationRepositoryInterface;
use Hash;

class AuthenticationService {
    protected $AuthenticationRepository;

    public function __construct(AuthenticationRepositoryInterface $AuthenticationRepository) {
        $this->AuthenticationRepository = $AuthenticationRepository;
    }

    public function getAll() {
        return $this->AuthenticationRepository->getAll();
    }

    public function getById(int $id) {
        return $this->AuthenticationRepository->getById($id);
    }

    public function create(array $data) {
        $data['password'] = Hash::make($data['password']);
        return $this->AuthenticationRepository->create($data);
    }

    public function update(int $id, array $data) {
        return $this->AuthenticationRepository->update($id, $data);
    }

    public function delete(int $id) {
        return $this->AuthenticationRepository->delete($id);
    }
}