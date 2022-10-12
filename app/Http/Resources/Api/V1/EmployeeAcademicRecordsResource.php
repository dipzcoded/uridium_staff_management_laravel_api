<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeAcademicRecordsResource extends JsonResource
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
            'courseOfStudy' => $this->course_of_study,
            'intitution' => $this->intitution,
            'qualification' => $this->qualification,
            'year_of_grad' => $this->year_of_grad
        ];
    }
}
