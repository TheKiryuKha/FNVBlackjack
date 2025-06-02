<?php

declare(strict_types=1);

namespace App\Actions\Fortify;

use App\Models\Croupier;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

final class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['nullable', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'] ?? 'default',
            'email' => $input['email'],
            'chips' => 1000,
            'chipsWon' => 0,
            'password' => Hash::make($input['password']),
            'email_verified_at' => now(),
        ]);

        return $user;
    }
}
