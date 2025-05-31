<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Croupier;
use App\Models\Game;
use App\Models\User;
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
            'game_id' => Game::factory(),
            'owner_id' => User::factory(),
            'owner_type' => 'user',
            'type' => $card->type,
            'suit' => $card->suit,
            'points' => $card->points,
        ];
    }

    public function croupiers(): self
    {
        return $this->state(fn (array $attributes) => [
            'owner_id' => Croupier::factory(),
            'owner_type' => 'croupier',
        ]);
    }
}
