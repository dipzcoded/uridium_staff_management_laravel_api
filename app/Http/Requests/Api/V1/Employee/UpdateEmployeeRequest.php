<?php

namespace App\Http\Requests\Api\V1\Employee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
             //
             'name' => ['sometimes','required','string'],
             'personalEmail' => ['sometimes','required','email'],
             'staffId' => ['sometimes','required','string'],
             'employmentDate' => ['sometimes','required','date_format:Y-m-d'],
             'sterlingBankEmail' => ['sometimes','required','email'],
             'position' => ['sometimes','required','string'],
             'department' => ['sometimes','required','string'],
             'grade' => ['sometimes','required','string'],
             'supervisor' => ['sometimes','required','string'],
             'bankAcctName' => ['sometimes','required','string'],
             'bankAcctNumber' => ['sometimes','required','string'],
             'bankBvn' => ['sometimes','required','string']
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
