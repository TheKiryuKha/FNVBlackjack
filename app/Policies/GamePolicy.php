<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\GameStatus;
use App\Models\Game;
use App\Models\User;

final class GamePolicy
{
    public function create(User $user): bool
    {
        return $user->game === null;
    }

    public function isGameOver(User $user)
    {
        if ($user->getPoints() >= 21) {
            return true;
        }
    }

    public function isCroupierMove(Game $game): bool
    {
        return $game->status === GameStatus::CroupiersMove;
    }

    public function isUser(User $user, Game $game): bool
    {
        return $user->id === $game->user_id;
    }
}
