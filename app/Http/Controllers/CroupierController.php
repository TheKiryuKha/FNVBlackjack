<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\GetCardsForCroupier;
use App\Models\Game;
use Illuminate\Http\JsonResponse;

final class CroupierController
{
    public function store(Game $game, GetCardsForCroupier $action): JsonResponse
    {
        $action->handle($game);

        return response()->json([
            'croupiers_cards' => $game->croupier->cards,
        ]);
    }
}
