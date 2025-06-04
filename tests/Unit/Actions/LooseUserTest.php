<?php

declare(strict_types=1);

use App\Actions\LooseUser;
use App\Models\Game;
use App\Models\User;

it('user looses', function () {
    $user = User::factory()->create(['chips' => 200]);
    $game = Game::factory()->create([
        'bet' => 200,
        'user_id' => $user->id,
    ]);
    $action = app(LooseUser::class);

    $action->handle($game);

    expect($user->fresh()->chips)->toBe(0);
});
