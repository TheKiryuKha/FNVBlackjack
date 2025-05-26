<?php

declare(strict_types=1);

use App\Models\Card;
use App\Models\Hand;

test('to array', function () {
    $card = Card::factory()->create()->fresh();

    expect(array_keys($card->toArray()))->toBe([
        'id',
        'hand_id',
        'type',
        'suit',
        'points',
        'created_at',
        'updated_at',
    ]);
});

it('belongs to Hand', function () {
    $hand = Hand::factory()->create();
    $card = Card::factory()->create([
        'hand_id' => $hand->id,
    ]);

    expect($card->hand)->toBeInstanceOf(Hand::class);
});
