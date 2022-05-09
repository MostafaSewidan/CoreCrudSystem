<?php

namespace Modules\Core\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

trait Response
{
    public function response($result, $message = 'Successfully')
    {
        $response = [
            'success' => true,
            'data' 		=> $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    public function error($error, $errorMessages = [], $code = 200)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function invalidData($error, $errorMessages = [], $code = 422)
    {
        $response = [
            'message' => 'The given data was invalid.',
            'errors' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }


    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, $this->invalidData($validator->errors()->first() , $validator->errors()));
    }
}
