<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Card;
use DB;
use stdClass;

final class CreateCard
{
    /** @param array{game_id: int, owner_id: int, owner_type: string} $attr */
    public function handle(array $attr): Card
    {
        return DB::transaction(function () use ($attr) {
            /** @var stdClass $card */
            $card = DB::table('deck')->inRandomOrder()->firstOrFail();

            return Card::create([
                'game_id' => $attr['game_id'],
                'owner_id' => $attr['owner_id'],
                'owner_type' => $attr['owner_type'],
                'type' => $card->type,
                'suit' => $card->suit,
                'points' => $card->points,
            ]);
        });
    }
}
