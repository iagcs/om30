<?php

namespace Modules\Patient\app\Services;

use Modules\Patient\app\DTO\PatientData;
use Modules\Patient\app\Models\Patient;

class PatientService
{
    /**
     * @throws \Spatie\LaravelData\Exceptions\InvalidDataClass
     */
    public function create(PatientData $data): PatientData
    {
        return \DB::transaction(static function() use ($data): PatientData{
            $patient = new Patient($data->toArray());
            $patient->save();

            return $patient->getData();
        });
    }

    /**
     * @throws \Spatie\LaravelData\Exceptions\InvalidDataClass
     */
    public function update(Patient $patient, PatientData $data): PatientData
    {
        return \DB::transaction( static function () use($patient, $data): PatientData{
            $patient->update($data->toArray());

            return $patient->getData();
        });
    }

    public function show(Patient $patient): PatientData
    {
        return $patient->getData();
    }

    public function insertInMass(array $data): void
    {
        \DB::transaction(static function() use ($data){
            Patient::query()->upsert($data, 'cpf');
        });
    }
}
