<?php

namespace Modules\Patient\app\DTO;

use Carbon\Carbon;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PatientData extends Data
{
    public function __construct(
        public string | Optional $id,
        public string | Optional $image,
        public string | Optional $full_name,
        public string | Optional $mothers_full_name,
        public string | Optional $date_of_birth,
        public string | Optional $cpf,
        public string | Optional $cns
    ) {}
}
