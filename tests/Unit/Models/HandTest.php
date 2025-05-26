<?php

declare(strict_types=1);

use App\Models\Card;
use App\Models\Hand;
use App\Models\User;

test('to array', function () {
    $hand = Hand::factory()->create()->fresh();

    expect(array_keys($hand->toArray()))->toBe([
        'id',
        'user_id',
        'points',
        'created_at',
        'updated_at',
    ]);
});

it('has Cards', function () {
    $hand = Hand::factory()->create();
    Card::factory()->count(3)->create([
        'hand_id' => $hand->id,
    ]);

    expect($hand->cards)->toHaveCount(3);
});

it('belongs to User', function () {
    $user = User::factory()->create();
    $hand = Hand::factory()->create([
        'user_id' => $user->id,
    ]);

    expect($hand->user)->toBeInstanceOf(User::class);
});
