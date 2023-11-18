<?php

namespace Modules\Patient\app\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Patient\app\DTO\AddressData;
use Modules\Patient\Database\factories\AddressFactory;
use Spatie\LaravelData\WithData;

class Address extends Model
{
    use HasUuids, HasFactory, WithData;

    protected $dataClass = AddressData::class;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'cep',
        'address',
        'number',
        'complement',
        'neighbour',
        'city',
        'state'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    protected static function newFactory(): AddressFactory
    {
        return AddressFactory::new();
    }
}
