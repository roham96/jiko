<?php

namespace App\Http\Requests;

use App\Enums\OtpTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OtpRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        //  if (request()->type == OtpTypes::SMS->value) {
        //     $this->valueRole = 'regex:/[0]{1}[0-9]{10}/';
        // } else {
        //     $this->valueRole = 'email';
        // }

        return [
            'type' => ['required', 'string', Rule::in(array_column( OtpTypes::cases(), 'value'))] ,//move this to enum
            'value' => 'string|required|' . $this->valueRole ,//add role validation for check mobile or email
        ];
    }
}