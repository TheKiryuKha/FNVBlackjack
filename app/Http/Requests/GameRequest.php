<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\UserHasEnoughChips;
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
     * @return array{bet: array{'required', 'integer', 'min:1', 'max:200', UserHasEnoughChips}}
     */
    public function rules(): array
    {
        return [
            'bet' => [
                'required',
                'integer',
                'min:1',
                'max:200',
                new UserHasEnoughChips(),
            ],
        ];
    }
}
