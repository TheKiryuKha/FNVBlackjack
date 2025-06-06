<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\DeleteGame;
use App\Actions\GetCardsForCroupier;
use App\Models\Game;
use Illuminate\Http\RedirectResponse;

final class CroupierController
{
    public function __invoke(Game $game, GetCardsForCroupier $action, DeleteGame $deleteGame): RedirectResponse
    {
        $action->handle($game);

        return to_route('games.show', $game);
    }
}
