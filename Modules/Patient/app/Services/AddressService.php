<?php

namespace Modules\Patient\app\Services;

use Illuminate\Support\Facades\Http;
use Modules\Patient\app\DTO\AddressData;
use Modules\Patient\app\Models\Address;
use Modules\Patient\app\Models\Patient;

class AddressService
{
    public function create(AddressData $data, Patient $patient): AddressData
    {
        return \DB::transaction(static function() use ($data, $patient): AddressData{
            $address = new Address($data->toArray());

            $address->patient()->associate($patient);
            $address->push();

            return $address->getData();
        });
    }

    public function update(Address $address, AddressData $data): AddressData
    {
        return \DB::transaction(function() use ($address, $data){
            $address->update($data->toArray());

            return $address->getData();
        });
    }

    public function show(Address $address): AddressData
    {
        return $address->getData();
    }

    public function searchByCep(string $cep): AddressData
    {
        $response = Http::get('https://viacep.com.br/ws/'.$cep.'/json/')->json();

        return AddressData::from([
            'cep'        => $response['cep'],
            'address'    => $response['logradouro'],
            'complement' => $response['complemento'],
            'neighbour'  => $response['bairro'],
            'city'       => $response['localidade'],
            'state'      => $response['uf'],
        ]);
    }
}
