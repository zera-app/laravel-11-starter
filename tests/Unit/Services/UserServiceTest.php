<?php

use App\Http\Requests\Tests\Store\StoreUserRequest;
use App\Http\Requests\Tests\Update\UpdateUserRequest;
use App\Interfaces\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

it('can get datatable', function () {
    
    User::factory()->count(10)->create();
    $request = new Request();

    $service = app(UserServiceInterface::class);
    $result = $service->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($result)->toBeCount(10);
});

it('can get datatable with search', function () {
    User::factory()->count(10)->create();
    User::factory()->create([
        'name' => 'TEST DATA',
    ]);
    $request = new Request([
        'search' => 'TEST DATA',
    ]);

    $service = app(UserServiceInterface::class);

    $result = $service->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($result)->toBeCount(1);
});

it('can get datatable with ordering', function () {
    
    User::factory()->count(10)->create();
    $request = new Request([
        'order' => '-name',
    ]);

    $service = app(UserServiceInterface::class);
    $result = $service->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($result)->toBeCount(10);
});

it('can get datatable with per page', function () {
    
    User::factory()->count(10)->create();
    $request = new Request([
        'per_page' => 5,
    ]);

    $service = app(UserServiceInterface::class);
    $result = $service->datatable($request);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($result)->toBeCount(5);
});

it('can create a User', function () {

    $fake = User::factory()->make()->toArray();

    $request = new FormRequest();
    $request = $request->setValidator(Validator::make(
        $fake,
        (new StoreUserRequest())->rules()
    ));

    $service = app(UserServiceInterface::class);

    $result = $service->create($request);

    $this->assertDatabaseHas('tableName', [
        'name' => $fake['name'],
    ]);
});

it('can update a User', function () {
    $User = User::factory()->create();

    $fake = User::factory()->make()->toArray();

    $request = new FormRequest();
    $request = $request->setValidator(Validator::make(
        $fake,
        (new StoreUserRequest())->rules()
    ));

    $service = app(UserServiceInterface::class);

    $result = $service->update($request, $User);

    $this->assertDatabaseHas('tableName', [
        'name' => $fake['name'],
    ]);
});

it('can delete a User', function () {
    $User = User::factory()->create();

    $service = app(UserServiceInterface::class);

    $result = $service->delete($User);

    expect(User::find($User->id))->toBeNull();

    $this->assertDatabaseMissing('tableName', [
        'name' => $User->name,
    ]);
});
