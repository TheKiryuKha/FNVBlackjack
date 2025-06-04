<?php

declare(strict_types=1);

use App\Actions\EditGame;
use App\Models\Game;

it('doubles game bet', function () {
    $game = Game::factory()->create(['bet' => 200]);
    $action = app(EditGame::class);

    $action->handle($game);

    expect($game->fresh()->bet)->toBe(400);
});
