<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Card;
use App\Models\Croupier;
use App\Models\Game;
use App\Models\User;
use DB;
use stdClass;

final class CreateCard
{
    public function handle(Game $game, User|Croupier $owner): Card
    {
        return DB::transaction(function () use ($game, $owner) {
            /** @var stdClass $card */
            $card = DB::table('deck')->inRandomOrder()->firstOrFail();

            return Card::create([
                'game_id' => $game->id,
                'owner_id' => $owner->id,
                'owner_type' => $this->getOwner($owner),
                'type' => $card->type,
                'suit' => $card->suit,
                'points' => $card->points,
            ]);
        });
    }

    private function getOwner(User|Croupier $owner): string
    {
        return match ($owner::class) {
            User::class => 'user',
            default => 'croupier'
        };
    }
}
