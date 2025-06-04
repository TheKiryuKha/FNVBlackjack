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
        $action->handle([
            'game_id' => $game->id,
            'owner_id' => $game->user->id,
            'owner_type' => 'user',
        ]);

        return to_route('games.show', $game);
    }
}
