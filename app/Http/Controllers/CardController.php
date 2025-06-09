<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateCard;
use App\Models\Game;

final class CardController
{
    public function __invoke(Game $game, CreateCard $action)
    {
        /** @var \App\Models\User $user */
        $user = $game->user;

        $action->handle([
            'game_id' => $game->id,
            'owner_id' => $user->id,
            'owner_type' => 'user',
        ]);

        return response()->json([
            'user_cards' => $game->user->cards 
        ]);
    }
}
