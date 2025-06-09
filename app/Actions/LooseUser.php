<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Game;
use DB;

final class LooseUser
{
    public function handle(Game $game): void
    {
        DB::transaction(function () use ($game) {
            $game->user->update([
                'chips' => $game->user->chips - $game->bet,
                'chipsWon' => $game->user->chipsWon - $game->bet
            ]);
        });
    }
}
