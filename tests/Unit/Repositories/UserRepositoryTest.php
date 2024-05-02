<?php

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

it('can get datatable', function () {
    
    User::factory()->count(10)->cerate();

    $request = new Request();
    $repository = new UserRepository();
    $result = $repository->datatable($request);
    
    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($result)->toBeCount(10);
});

it('can get datatable with search', function () {

    User::factory()->count(10)->create();
    User::factory()->create([
        '' => 'TEST SEARCH'
    ]);

    $repository = new UserRepository();
    $request = new Request([
        'search' => 'TEST SEARCH',
    ]);

    $result = $repository->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($result)->toBeCount(1);
});

it('can get datatable with order by', function () {

    User::factory()->count(10)->create();

    $repository = new UserRepository();
    $request = new Request([
        'order' => '-name',
    ]);

    $result = $repository->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($result)->toBeCount(10);
});

it('can get datatable with paginate', function () {

    User::factory()->count(10)->create();

    $repository = new UserRepository();
    $request = new Request([
        'per_page' => '5',
    ]);

    $result = $repository->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($result)->toBeCount(5);
});

it('can create a User', function () {
    $repository = new UserRepository();
    $data = User::factory()->make()->toArray();

    $object = new \App\DataTransferObjects\UserObject();
    $result = $repository->create($object);

    expect($result)->toBeInstanceOf(User::class);
    expect($result->name)->toEqual($data['name']);

    $this->assertDatabaseHas('{{table}}', [
        'name' => $data['name'],
    ]);
});

it('can update a User', function () {
    $repository = new UserRepository();
    $User = User::factory()->create();

    $object = new \App\DataTransferObjects\UserObject();
    $result = $repository->update($object, $User->id);

    expect($result)->toBeInstanceOf(User::class);
    expect($result->name)->toEqual('Jane Smith');

    $this->assertDatabaseHas('{{table}}', [
        '' => '',
    ]);
});

it('can delete a User', function () {
    $repository = new UserRepository();
    $User = User::factory()->create();

    $repository->delete($User->id);

    expect(User::find($User->id))->toBeNull();

    $this->assertDatabaseMissing('{{table}}', [
        'name' => $User->name,
    ]);
});
