<?php

namespace App\Http\Requests\Api\V1\Employee;

use Illuminate\Foundation\Http\FormRequest;

class BulkCreateEmployeeDetailsRequest extends FormRequest
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
            '*.staffName' => ['required','string'],
            '*.staffId' => ['required','string'],
            '*.employmentDate' => ['date_format:Y-m-d H:i:s'],
            '*.sterlingBankEmail' => ['required','email'],
            '*.position' => ['required','string'],
            '*.department' => ['required','string'],
            '*.grade' => ['required','string'],
            '*.supervisor' => ['required','string'],
            '*.bankAcctName' => ['required','string', 'nullable'],
            '*.bankAcctNumber' => ['required','string'],
            '*.bankBvn' => ['required','string'],
            '*.nin' => ['required','string'],
            '*.personalEmail' => ['required','email'],
            '*.sex' => ['required','string'],
            '*.dateOfBirth' => ['required','date_format:Y-m-d H:i:s'],
            '*.stateOfOrigin' => ['required','string'],
            '*.maritalStatus' => ['required','string'],
            '*.religion' => ['required','string'],
            '*.phoneNumber' => ['required','string'],
            '*.homeAddress' => ['required','string']
        ];
    }

    protected function prepareForValidation()
    {
        $data = [];

        foreach($this->toArray()as $obj)
        {
            $obj['name'] = $obj['staffName'] ?? null;
            $obj['staff_id'] = $obj['staffId'] ?? null;
            $data[] = $obj;
        }

        $this->merge($data);
    }
}
