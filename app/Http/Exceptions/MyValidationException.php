<?php

namespace App\Http\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\Validator;

class MyValidationException extends Exception
{
    protected Validator  $validator;
    protected $code = 422;

    public function __construct(Validator $validator)
    {
        parent::__construct();
        $this->validator = $validator;
    }

    public function render()
    {
        return response()->json([
            'result' => 'error',
            'code' => $this->code,
            'message' => $this->validator->errors()->first(),
        ], $this->code);
    }
}