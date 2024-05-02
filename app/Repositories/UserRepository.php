<?php

namespace App\Repositories;

use App\DataTransferObjects\UserObject;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\Base\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Instantiate a new UserRepository instance.
     */
    public function __construct()
    {
        $this->setAllowableSearch([
            //
        ]);

        $this->setAllowableSort([
            //
        ]);
    }

    /**
     * Datatable query for User.
     */
    public function datatable(Request $request): LengthAwarePaginator
    {
        return User::query()
            ->when($request->search, function ($query, $search) {
                $this->getAllowableSearchQuery($query, $search);
            })
            ->orderBy($this->getSortColumn(), $this->getSortDirection())
            ->paginate($request->per_page ?? config('app.default_paginator'));
    }

    /**
     * Create a new User.
     */
    public function create(UserObject $data): User
    {
        $data =  User::create($data->toArray());

        return $data;
    }

    /**
     * Find a User by id.
     */
    public function show(string $id): User
    {
        $data =  User::with($this->getAllowableFilter())->findOrFail($id);

        return $data;
    }

    /**
     * Update a User,
     */
    public function update(UserObject $data, string $id): User
    {
        $model = User::findOrFail($id);
        $model->update($data->toArray());

        return $model;
    }

    /**
     * Delete a User,
     */
    public function delete(string $id): void
    {
        $data = User::findOrFail($id);
        $data->delete();
    }
}