<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Game;
use DB;

final class WinUser
{
    public function handle(Game $game): void
    {
        DB::transaction(function () use ($game) {
            /** @var \App\Models\User $user */
            $user = $game->user;

            /** @var \App\Models\Croupier $croupier */
            $croupier = $game->croupier;

            $user->chips = $user->chips + $game->bet;
            $user->chipsWon = $user->chipsWon + $game->bet;
            $user->save();
        });
    }
}
