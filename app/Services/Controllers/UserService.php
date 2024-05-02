<?php

namespace App\Services\Controllers;

use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Interfaces\Services\UserServiceInterface;
use App\Models\User;
use App\Services\Base\BaseService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService extends BaseService implements UserServiceInterface
{
    /**
     * The constructor function for UserService.
     */
    public function __construct(private UserRepositoryInterface $repository)
    {
        // 
    }

    /**
     * Get data User for datatable.
     */
    public function datatable(Request $request): LengthAwarePaginator
    {
        return $this
            ->repository
            ->datatable($request);
    }

    /**
     * Create a new data User
     */
    public function create(FormRequest $request): void
    {
         $this->repository->create($request->validated());
    }

    /**
     * Find a single data User from id.
     */
    public function show(string $id): User
    {
         return $this->repository->show($id);
    }

    /**
     * Update a data User.
     */
    public function update(FormRequest $request, User $User): void
    {
        $this->repository->update($request->validated(), $User->id);
    }

    /**
     * Delete a data User.
     */
    public function delete(User $User): void
    {
         $this->repository->delete($User->id);
    }
}