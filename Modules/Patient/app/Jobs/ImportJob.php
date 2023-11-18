<?php

namespace Modules\Patient\app\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Patient\app\DTO\PatientData;
use Modules\Patient\app\Services\PatientService;

class ImportJob implements ShouldQueue
{
    use Dispatchable, Batchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly array $data) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $patientService = new PatientServiceas;

        $patientService->insertInMass(PatientData::collection($this->data)->toArray());
    }
}
