<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class JsonRequest extends FormRequest
{
    /**
     * @inheritdoc
     */
    public function response(array $errors)
    {
        return new JsonResponse($errors, 422);
    }
}