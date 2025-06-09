<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\GetCardsForCroupier;
use App\Models\Game;
use Illuminate\Http\JsonResponse;

final class CroupierController
{
    public function __invoke(Game $game, GetCardsForCroupier $action): JsonResponse
    {
        $action->handle($game);

        /** @var \App\Models\Croupier $croupier */
        $croupier = $game->croupier;

        return response()->json([
            'croupiers_cards' => $croupier->cards,
        ]);
    }
}
