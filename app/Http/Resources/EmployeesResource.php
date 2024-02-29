<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return  [
            'id' => $this->id,
           'firstname'=>$this->firstname,
           'lastname'=>$this->lastname,
           'address'=>$this->address,
           'cityId'=>$this->city_id,
           'stateId'=>$this->state_id,
           'countryId'=>$this->country_id,
           'departmentId'=>$this->departement_id,
           'zip_code'=>$this->zip_code,
           'birth_date'=>$this->birth_date,
           'date_hired'=>$this->date_hired
       ];
    }
}
