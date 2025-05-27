<?php

declare(strict_types=1);

use App\Models\User;

test('authorized user can see home page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('home'))
        ->assertStatus(200);
});
