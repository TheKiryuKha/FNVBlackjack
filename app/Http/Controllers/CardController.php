<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateCard;
use App\Models\Game;
use Illuminate\Http\RedirectResponse;

final class CardController
{
    public function __invoke(Game $game, CreateCard $action): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = $game->user;

        $action->handle([
            'game_id' => $game->id,
            'owner_id' => $user->id,
            'owner_type' => 'user',
        ]);

        return to_route('games.show', $game);
    }
}
