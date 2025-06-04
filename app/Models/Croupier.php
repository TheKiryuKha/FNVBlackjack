<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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

    public function getMorphClass(): string
    {
        return 'croupier';
    }

    public function getPoints(): int
    {
        return collect($this->cards)->sum('points');
    }
}
