<?php

declare(strict_types=1);

use App\Models\Game;
use App\Models\User;

test('authorized user can see start game page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('games.create'))
        ->assertStatus(200);
});

test('user in game cannot see start game page', function () {
    $user = User::factory()->create();
    Game::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->get(route('games.create'))
        ->assertStatus(403);
});
