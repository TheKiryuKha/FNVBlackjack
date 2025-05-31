<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\GameStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Game extends Model
{
    /** @use HasFactory<\Database\Factories\GameFactory> */
    use HasFactory;

    protected $casts = [
        'status' => GameStatus::class
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
