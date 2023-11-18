<?php

namespace Modules\Patient\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Patient\app\Http\Requests\ImportRequest;
use Modules\Patient\app\Http\Requests\PatientRequest;
use Modules\Patient\app\Models\Patient;
use Modules\Patient\app\Resources\PatientResource;
use Modules\Patient\app\Services\ImportService;
use Modules\Patient\app\Services\PatientService;
use Symfony\Component\HttpFoundation\Response;

class PatientController extends Controller
{

    public function __construct(private PatientService $service) {}

    /**
     * @throws \Spatie\LaravelData\Exceptions\InvalidDataClass
     */
    public function create(PatientRequest $request): PatientResource
    {
        return PatientResource::make($this->service->create($request->getData()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws \Spatie\LaravelData\Exceptions\InvalidDataClass
     */
    public function update(Patient $patient, PatientRequest $request): PatientResource
    {
        return PatientResource::make($this->service->update($patient, $request->getData()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws \Spatie\LaravelData\Exceptions\InvalidDataClass
     */
    public function show(Patient $patient): PatientResource
    {
        return PatientResource::make($this->service->show($patient));
    }

    /**
     * @throws \Throwable
     */
    public function import(ImportRequest $request): \Illuminate\Http\JsonResponse
    {
        (new ImportService)->import($request->file('patients'), \Auth::user());

        return response()->json(Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient): \Illuminate\Http\JsonResponse
    {
        if ($patient->delete()) {
            return response()->json(Response::HTTP_NO_CONTENT);
        }

        return response()->json(Response::HTTP_BAD_REQUEST);
    }
}
