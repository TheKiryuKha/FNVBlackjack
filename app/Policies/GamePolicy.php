<?php

namespace App\Policies;

use App\Enums\GameStatus;
use App\Models\Game;
use App\Models\User;

class GamePolicy
{
    public function create(User $user): bool
    {
        return $user->game === null;
    }

    public function show(User $user, Game $game): bool
    {
        return $user->id === $game->user_id;
    }

    public function isGameOver(User $user)
    {
        if($user->getPoints() >= 21){
            return true;
        }
    }

    public function isCroupierMove(Game $game): bool
    {
        return $game->status === GameStatus::CroupiersMove;
    }

    public function destroy(User $user, Game $game): bool
    {
        return $user->id === $game->user_id;
    }

    public function update(User $user, Game $game): bool
    {
        return $user->id === $game->user_id;
    }
}
