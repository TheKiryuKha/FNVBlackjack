<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateCard;
use App\Models\Game;
use Illuminate\Http\JsonResponse;

final class CardController
{
    public function store(Game $game, CreateCard $action): JsonResponse
    {
        $action->handle($game, $game->user);

        return response()->json([
            'user_cards' => $game->user->cards,
        ]);
    }
}
