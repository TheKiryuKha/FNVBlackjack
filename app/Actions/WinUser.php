<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Game;
use App\Models\User;
use DB;

final class WinUser
{
    public function handle(User $user): void
    {
        DB::transaction(function () use ($user) {
            /** @var Game $game */
            $game = $user->game;

            $user->update([
                'chips' => $user->chips + $game->bet,
                'chipsWon' => $user->chipsWon + $game->bet,
            ]);
        });
    }
}
