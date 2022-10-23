<?php

namespace App\Http\Requests\Api\V1\Employee;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRequest extends FormRequest
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
            'name' => ['required','string'],
            'personalEmail' => ['required','email'],
            'staffId' => ['required','string'],
            'employmentDate' => ['required','date_format:Y-m-d'],
            'sterlingBankEmail' => ['required','email'],
            'position' => ['required','string'],
            'department' => ['required','string'],
            'grade' => ['required','string'],
            'supervisor' => ['required','string'],
            'bankAcctName' => ['required','string'],
            'bankAcctNumber' => ['required','string'],
            'bankBvn' => ['required','string']

        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'staff_id' => $this->staffId,
            'employment_date' => $this->employmentDate,
            'sterling_bank_email' => $this->sterlingBankEmail,
            'bank_acct_name' => $this->bankAcctName,
            'bank_acct_number' => $this->bankAcctNumber
        ]);
    }
}
