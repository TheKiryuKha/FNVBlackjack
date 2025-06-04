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
            /** @var \App\Models\User $user */
            $user = $game->user;

            /** @var \App\Models\Croupier $croupier */
            $croupier = $game->croupier;

            $userPoints = $user->getPoints();
            $croupierPoints = $croupier->getPoints();

            if ($userPoints > 21) {
                $this->looseAction->handle($game);
            } elseif ($croupierPoints > 21) {
                $this->winAction->handle($game);
            } elseif ($userPoints > $croupierPoints) {
                $this->winAction->handle($game);
            } elseif ($userPoints < $croupierPoints) {
                $this->looseAction->handle($game);
            }

            $user->cards()->delete();
            $croupier->cards()->delete();

            $game->delete();
        });
    }
}
