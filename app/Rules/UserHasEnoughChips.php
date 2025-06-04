<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

final class UserHasEnoughChips implements Rule
{
    /**
     * @param  string  $attribute
     * @param  int  $value
     */
    public function passes($attribute, $value): bool
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        return $user->chips >= $value;
    }

    public function message(): string
    {
        return 'У вас недостаточно фишек для этой ставки';
    }
}
