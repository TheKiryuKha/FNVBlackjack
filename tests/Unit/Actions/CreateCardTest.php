<?php

declare(strict_types=1);

use App\Actions\CreateCard;
use App\Models\Card;
use App\Models\Game;
use App\Models\User;

it('creates card', function () {
    $action = app(CreateCard::class);
    $user = User::factory()->create();
    $game = Game::factory()->create();

    $action->handle($game, $user);

    expect(Card::count())->toBe(1)
        ->and(Card::first())
        ->game->toBeInstanceOf(Game::class)
        ->owner->toBeInstanceOf(User::class);
});
