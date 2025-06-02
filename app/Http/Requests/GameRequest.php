<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class GameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bet' => ['required', 'integer', 'min:1', 'max:200',
                function ($attribute, $value, $fail) {
                    /** @var \App\Models\User $user */
                    $user = auth()->user();

                    if ($user->chips < $value) {
                        $fail('У вас недостаточно фишек для этой ставки');
                    }
                }],
        ];
    }
}
