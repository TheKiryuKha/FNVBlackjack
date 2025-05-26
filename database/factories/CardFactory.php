<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Hand;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
final class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var object{type: string, suit: string, points: int} $card */
        $card = DB::table('deck')->inRandomOrder()->firstOrFail();

        return [
            'hand_id' => Hand::factory(),
            'type' => $card->type,
            'suit' => $card->suit,
            'points' => $card->points,
        ];
    }
}
