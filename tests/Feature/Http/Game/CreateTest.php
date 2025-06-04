<?php

declare(strict_types=1);

use App\Models\User;

test('authorized user can see start game page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('games.create'))
        ->assertStatus(200);
});
