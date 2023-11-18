<?php

namespace Modules\Patient\app\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read \Modules\Patient\app\DTO\AddressData $resource
 */
class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'cep'        => $this->resource->cep,
            'address'    => $this->resource->address,
            'complement' => $this->resource->complement,
            'neighbour'  => $this->resource->neighbour,
            'city'       => $this->resource->city,
            'state'      => $this->resource->state,
        ];
    }
}
