<?php

namespace Modules\Core\Traits\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

trait Response
{
    public function response($result, $message = 'Successfully',$status = 1)
    {
        $response = [
            'status' => $status,
            'success' => true,
            'data' 		=> $result,
            'message' => $message == 'Successfully' ? __('apps::api.message.successfully') : $message,
        ];

        return response()->json($response, 200);
    }

    public function error($error, $errorMessages = [], $code = 200, $status = 0)
    {
        $response = [
            'status' => $status,
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function invalidData($error, $errorMessages = [], $code = 422, $status = 0)
    {
        $response = [
            'status' => $status,
            'success' => false,
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
