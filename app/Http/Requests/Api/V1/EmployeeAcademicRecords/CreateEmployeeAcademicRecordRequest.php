<?php

namespace App\Http\Requests\Api\V1\EmployeeAcademicRecords;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeAcademicRecordRequest extends FormRequest
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
            'courseOfStudy' => ['required','string'],
            'intitution' => ['required','string'],
            'qualification' => ['required','string'],
            'yearOfGrad' => ['required','date_format:Y-m-d']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'course_of_study' => $this->courseOfStudy,
            'year_of_grad' => $this->yearOfGrad
        ]);
    }
}
