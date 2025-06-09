<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Collection<int, Card> $cards
 * @property-read Game|null $game
 */
final class Croupier extends Model
{
    /** @use HasFactory<\Database\Factories\CroupierFactory> */
    use HasFactory;

    public static function getRandomCroupier(): self
    {
        return self::inRandomOrder()->firstOrFail();
    }

    /** @return MorphMany<Card, $this>*/
    public function cards(): MorphMany
    {
        return $this->morphMany(Card::class, 'owner');
    }

    /** @return HasOne<Game, $this> */
    public function game(): HasOne
    {
        return $this->hasOne(Game::class);
    }

    public function getMorphClass(): string
    {
        return 'croupier';
    }

    public function getPoints(): int
    {
        return collect($this->cards)
            ->sum(fn (Card $card) => $card->points);
    }
}
