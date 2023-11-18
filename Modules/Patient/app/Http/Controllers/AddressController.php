<?php

namespace Modules\Patient\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Patient\app\Http\Requests\AddressRequest;
use Modules\Patient\app\Http\Requests\CepRequest;
use Modules\Patient\app\Models\Address;
use Modules\Patient\app\Models\Patient;
use Modules\Patient\app\Resources\AddressResource;
use Modules\Patient\app\Services\AddressService;
use Symfony\Component\HttpFoundation\Response;

class AddressController extends Controller
{
    public function __construct(private readonly AddressService $service) {}

    /**
     * @throws \Spatie\LaravelData\Exceptions\InvalidDataClass
     */
    public function create(AddressRequest $request, Patient $patient): AddressResource
    {
        return AddressResource::make($this->service->create($request->getData(), $patient));
    }

    /**
     * @throws \Spatie\LaravelData\Exceptions\InvalidDataClass
     */
    public function update(Address $address, AddressRequest $request): AddressResource
    {
        return AddressResource::make($this->service->update($address, $request->getData()));
    }

    /**
     * @throws \Spatie\LaravelData\Exceptions\InvalidDataClass
     */
    public function show(Address $address): AddressResource
    {
        return AddressResource::make($this->service->show($address));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address): \Illuminate\Http\JsonResponse
    {
        if ($address->delete()) {
            return response()->json(Response::HTTP_NO_CONTENT);
        }

        return response()->json(Response::HTTP_BAD_REQUEST);
    }

    public function search(CepRequest $request): AddressResource
    {
        return AddressResource::make($this->service->searchByCep($request->cep));
    }
}
