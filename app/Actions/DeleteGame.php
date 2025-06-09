<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Game;
use DB;

final class DeleteGame
{
    public function __construct(
        private WinUser $winAction,
        private LooseUser $looseAction
    ) {}

    public function handle(Game $game): void
    {
        DB::transaction(function () use ($game) {
            $userPoints = $game->user->getPoints();
            $croupierPoints = $game->croupier->getPoints();

            if ($userPoints > 21) {
                $this->looseAction->handle($game->user);
            } elseif ($croupierPoints > 21) {
                $this->winAction->handle($game->user);
            } elseif ($userPoints > $croupierPoints) {
                $this->winAction->handle($game->user);
            } elseif ($userPoints < $croupierPoints) {
                $this->looseAction->handle($game->user);
            }

            $game->user->cards()->delete();
            $game->croupier->cards()->delete();

            $game->delete();
        });
    }
}
