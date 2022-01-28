<?php

namespace App\Http\Requests;

use App\Http\Exceptions\MyValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CreatePlayerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'auto' => 'boolean|nullable',
            'display_name' => 'string|min:1|required_without:auto',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator) {
        throw new MyValidationException($validator);
    }
}

/**
 * @OA\Schema (
 *     schema="CreatePlayerRequest",
 *     type="object",
 *     title="Create Player Request",
 *     properties={
 *         @OA\Property(property="display_name", type="string", example="TestPlayer"),
 *     }
 * )
 */