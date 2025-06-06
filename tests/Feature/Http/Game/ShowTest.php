<?php

declare(strict_types=1);

use App\Models\Game;
use App\Models\User;

test('user can see his game page', function () {
    $user = User::factory()->create();
    $game = Game::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->get(route('games.show', $game))
        ->assertStatus(200);
});
