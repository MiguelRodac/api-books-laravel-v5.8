<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService
{
    /**
     * Get all users.
     */
    public function getAll(): Collection
    {
        return User::all();
    }

    /**
     * Find user by ID.
     */
    public function find(int $id): User
    {
        $user = User::find($id);

        if (!$user) {
            throw new ModelNotFoundException('Usuario no encontrado');
        }

        return $user;
    }

    /**
     * Create a new user with hashed password.
     */
    public function store(array $data): User
    {
        // Hash the password before storing
        $data['password'] = Hash::make($data['password']);

        return User::create($data);
    }

    /**
     * Update existing user and re-hash password if provided.
     */
    public function update(int $id, array $data): User
    {
        $user = $this->find($id);

        // Only hash password if present
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Prevent overriding password with null
            unset($data['password']);
        }

        $user->update($data);

        return $user;
    }

    /**
     * Delete user.
     */
    public function delete(int $id): bool
    {
        $user = $this->find($id);

        return $user->delete();
    }
}
