<?php

declare(strict_types=1);

use App\Models\Hand;
use App\Models\User;

test('to array', function () {
    $user = User::factory()->create()->fresh();

    expect(array_keys($user->toArray()))->toBe([
        'id',
        'name',
        'email',
        'email_verified_at',
        'created_at',
        'updated_at',
    ]);
});

it('has Hand', function () {
    $user = User::factory()->create();
    Hand::factory()->create([
        'user_id' => $user->id,
    ]);

    expect($user->hand)->toBeInstanceOf(Hand::class);
});
