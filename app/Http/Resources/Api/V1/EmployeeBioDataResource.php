<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeBioDataResource extends JsonResource
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
            'personalEmail' => $this->personal_email,
            'sex' => $this->sex,
            'dateOfBirth' => $this->date_of_birth,
            'stateOfOrigin' => $this->state_of_origin,
            'maritalStatus' => $this->marital_status,
            'religion' => $this->religion,
            'phone_number' => $this->phone_number,
            'homeAddress' => $this->home_address,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
