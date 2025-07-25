<?php

namespace App\Repositories;

use App\Models\User;

class AuthenticationRepository implements AuthenticationRepositoryInterface {
    public function getAll() {
        return User::all();
    }   

    public function getById(int $id) {
        return User::findOrFail($id);
    }

    public function create(array $data) {
        return User::create($data);
    }

    public function update(int $id, array $data) {
        $record = User::findOrFail($id);
        $record->update($data);
        return $record;
    }

    public function delete(int $id) {
        $record = User::findOrFail($id);
        return $record->delete();
    }
}