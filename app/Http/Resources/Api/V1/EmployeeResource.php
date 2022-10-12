<?php

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Api\V1\EmployeeBioDataResource;
use App\Http\Resources\Api\V1\EmployeeAcademicRecordsResource;
use App\Http\Resources\Api\V1\EmployeeNextOfKinsResource;
use App\Http\Resources\Api\V1\EmployeeGuarantorsResource;
use App\Http\Resources\Api\V1\EmployeeUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => (string) $this->id,
            'type' => 'Employees',
            'attributes' => [
                'staffId' => $this->staff_id,
                'employmentDate' => $this->employment_date,
                'sterlingBankEmail' => $this->sterling_bank_email,
                'position' => $this->position,
                'department' => $this->department,
                'grade' => $this->grade,
                'supervisor' => $this->supervisor,
                'bankAcctName' => $this->bank_acct_name,
                'bankAcctNumber' => $this->bank_acct_number,
                'bankBvn' => $this->bank_bvn,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at
            ],
            'relationships' => [
                'user' => new EmployeeUserResource($this->user),
                'bioData' => new EmployeeBioDataResource($this->bioData),
                'academicRecords' => EmployeeAcademicRecordsResource::collection($this->academicRecords),
                'nextOfKins' => EmployeeNextOfKinsResource::collection($this->nextOfKins),
                'guarantors' => EmployeeGuarantorsResource::collection($this->guarantors)
                
            ]
        ];
    }
}
