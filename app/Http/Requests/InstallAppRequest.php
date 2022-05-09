<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class InstallAppRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'admin.name'            => 'required',
            'admin.mobile'          => 'required',
            'admin.email'           => 'required|email',
            'admin.password'        => 'required|confirmed',
            'app.app_name'          => 'required',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            '*.required'      => 'The :attribute field is required.',
            '*.required_if'   => 'The :attribute field is required when :other is :value.',
            '*.email'         => 'The :attribute must be a valid email address.',
            '*.unique'        => 'The :attribute has already been taken.',
            '*.confirmed'     => 'The :attribute confirmation does not match.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'db.host'               => 'host',
            'db.port'               => 'port',
            'db.username'           => 'username',
            'db.password'           => 'password',
            'db.database'           => 'datbase',
            'admin.name'            => 'name',
            'admin.mobile'          => 'mobile',
            'admin.email'           => 'email',
            'admin.password'        => 'password',
            'app.app_name'          => 'app name',
        ];
    }
}
