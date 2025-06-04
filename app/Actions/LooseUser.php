<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use DB;

final class LooseUser
{
    public function handle(User $user, int $bet): void
    {
        DB::transaction(function () use ($user, $bet) {
            $user->chips = $user->chips - $bet;
            $user->chipsWon = $user->chipsWon - $bet;
            $user->save();
        });
    }
}
