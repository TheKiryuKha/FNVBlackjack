<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use \Carbon\Carbon;
use \App\Enums\CardSuit;
use \App\Enums\CardFace;

/**
 * @property-read int $id
 * @property-read int $game_id
 * @property-read int $owner_id
 * @property-read string $owner_type
 * @property-read CardFace|string $type
 * @property-read CardSuit $suit
 * @property-read int $points
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * 
 * @property-read User|Croupier $owner
 * @property-read Game $game
 */
final class Card extends Model
{
    /** @use HasFactory<\Database\Factories\CardFactory> */
    use HasFactory;

    protected $casts = [
        'type' => CardFace::class,
        'suit' => CardSuit::class
    ];

    /** @return MorphTo<Model, $this>*/
    public function owner(): MorphTo
    {
        return $this->morphTo();
    }

    /** @return BelongsTo<Game, $this>*/
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
