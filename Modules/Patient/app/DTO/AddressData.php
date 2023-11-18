<?php

namespace Modules\Patient\app\DTO;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class AddressData extends Data
{
    public function __construct(
        public string | Optional $cep,
        public string | Optional $address,
        public string | Optional $number,
        public string | Optional $complement,
        public string | Optional $neighbour,
        public string | Optional $city,
        public string | Optional $state,
    ) {}
}
