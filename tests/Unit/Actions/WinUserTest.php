<?php

declare(strict_types=1);

use App\Actions\WinUser;
use App\Models\Game;
use App\Models\User;

it('user looses', function () {
    $user = User::factory()->create(['chips' => 200]);
    $game = Game::factory()->create([
        'bet' => 200,
        'user_id' => $user->id,
    ]);
    $action = app(WinUser::class);

    $action->handle($user);

    expect($user->fresh()->chips)->toBe(400);
});
