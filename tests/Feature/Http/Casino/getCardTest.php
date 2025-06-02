<?php

declare(strict_types=1);

use App\Models\Game;
use App\Models\User;

test('user get card', function () {
    $user = User::factory()->create();
    $game = Game::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->from(route('game', $game))
        ->post(route('getCard', $game))
        ->assertRedirectToRoute('game', $game);

    expect($user->fresh()->cards)->toHaveCount(1);
});
