<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $email
 * @property-read int $chips
 * @property-read int $chipsWon
 * @property-read DateTimeInterface|null $email_verified_at
 * @property-read string $password
 * @property-read string|null $remember_token
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Game|null $game
 * @property-read Collection<int, Card> $cards
 */
final class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** @return MorphMany<Card, $this>*/
    public function cards(): MorphMany
    {
        return $this->morphMany(Card::class, 'owner');
    }

    /** @return HasOne<Game, $this>*/
    public function game(): HasOne
    {
        return $this->hasOne(Game::class);
    }

    public function getPoints(): int
    {
        return collect($this->cards)
            ->sum(fn (Card $card) => $card->points);
    }

    public function getMorphClass(): string
    {
        return 'user';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
