<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SmsApiRequest extends FormRequest
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
            'provider_name' => 'required|string',
            'sms_username' => 'required|string',
            'otp_username' => 'required|string',
            'sms_password' => 'required|string',
            'sms_sid' => 'required|string',
            'api_key' => 'required|string',
            'status' => 'required|in:1,0',
        ];
    }
}
