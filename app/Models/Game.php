<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\GameStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use \Illuminate\Database\Eloquent\Collection;

/**
 * @property-read int $id
 * @property-read int $user_id
 * @property-read int $croupier_id
 * @property-read int $bet
 * @property-read GameStatus $status
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * 
 * @property-read Collection<int, Card> $cards
 * @property-read Croupier $croupier
 * @property-read User $user
 */
final class Game extends Model
{
    /** @use HasFactory<\Database\Factories\GameFactory> */
    use HasFactory;

    protected $casts = [
        'status' => GameStatus::class,
    ];

    /** @return HasMany<Card, $this>*/
    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    /** @return BelongsTo<Croupier, $this>*/
    public function croupier(): BelongsTo
    {
        return $this->belongsTo(Croupier::class);
    }

    /** @return BelongsTo<User, $this>*/
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
