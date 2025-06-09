<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\GameStatus;
use App\Models\Game;
use DB;

final class EditGame
{
    public function handle(Game $game): void
    {
        DB::transaction(function () use ($game) {
            $game->update([
                'bet' => $game->bet * 2,
                'status' => GameStatus::CroupiersMove
            ]);
        });
    }
}
