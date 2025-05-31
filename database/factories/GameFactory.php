<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\GameStatus;
use App\Models\Croupier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
final class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'croupier_id' => Croupier::factory(),
            'bet' => rand(1, 200),
            'status' => GameStatus::PlayersMove,
        ];
    }

    public function croupiersMove(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => GameStatus::CroupiersMove,
        ]);
    }
}
