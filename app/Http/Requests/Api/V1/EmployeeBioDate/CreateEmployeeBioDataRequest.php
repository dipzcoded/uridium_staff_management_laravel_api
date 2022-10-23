<?php

namespace App\Http\Requests\Api\V1\EmployeeBioDate;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeBioDataRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'personalEmail' => ['required','email','unique:employee_bio_data,personal_email'],
            'sex' => ['required','string'],
            'dateOfBirth' => ['required','date_format:Y-m-d'],
            'stateOfOrigin' =>['required','string'],
            'maritalStatus' => ['required','string'],
            'religion' => ['required','string'],
            'phoneNumber' => ['required','string'],
            'homeAddress' => ['required','string'],
            'nin' => ['required','string']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
        'personal_email' => $this->personalEmail,
        'date_of_birth' => $this->dateOfBirth,
        'state_of_origin' => $this->stateOfOrigin,
        'marital_status' => $this->maritalStatus,
        'phone_number' => $this->phoneNumber,
        'home_address' => $this->homeAddress
        ]);
    }
}
