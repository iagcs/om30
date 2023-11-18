<?php

namespace Modules\Patient\app\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read \Modules\Patient\app\DTO\PatientData $resource
 */
class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'image'             => $this->resource->image,
            'full_name'         => $this->resource->full_name,
            'mothers_full_name' => $this->resource->mothers_full_name,
            'date_of_birth'     => $this->resource->date_of_birth,
            'cpf'               => $this->resource->cpf,
            'cns'               => $this->resource->cns,
        ];
    }
}
