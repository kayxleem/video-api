<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseFormRequest extends FormRequest
{

    /**
     * Process error message on 422 and return json readable response on 422
     *
     * @param Validator $validator
     * @return HttpResponseException
     */

    public function failedValidation(Validator $validator): HttpResponseException{
        $errors = $validator->errors()->messages();
        $transformed = [];
        foreach ($errors as $field => $messages) {
            $transformed[$field] = $messages[0];
        }
        // Format message
        $response = response()->json([
            'message' => 'Fields are required',
            'code' => 422,
            'errors' => $transformed,
        ], 422);

        throw new HttpResponseException($response);
    }
}
