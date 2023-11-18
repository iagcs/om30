<?php

namespace Modules\Patient\app\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Patient\app\DTO\PatientData;
use Modules\Patient\Database\factories\PatientFactory;
use Spatie\LaravelData\WithData;

class Patient extends Model
{
    use HasUuids, HasFactory, WithData;

    protected $dataClass = PatientData::class;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'full_name',
        'mothers_full_name',
        'date_of_birth',
        'cpf',
        'cns',
        'image'
    ];

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    protected static function newFactory(): PatientFactory
    {
        return PatientFactory::new();
    }
}
