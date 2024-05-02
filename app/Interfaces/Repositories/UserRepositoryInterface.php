<?php

namespace App\Interfaces\Repositories;

use App\DataTransferObjects\UserObject;
use App\Interfaces\Base\BaseRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Datatable query for User.
     */
    public function datatable(Request $request): LengthAwarePaginator;

    /**
     * Create a new User.
     */
    public function create(UserObject $data): User;
    
    /**
     * Find a User by using id.
     */
    public function show(string $id): User;

    /**
     * Update a User.
     */
    public function update(UserObject $data, string $id): User;

    /**
     * Delete a User.
     */
    public function delete(string $id): void;
}