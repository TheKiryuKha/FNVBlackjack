<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final class Card extends Model
{
    /** @use HasFactory<\Database\Factories\CardFactory> */
    use HasFactory;

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
