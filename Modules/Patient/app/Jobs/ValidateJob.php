<?php

namespace Modules\Patient\app\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\Patient\app\Rules\Cns;
use Modules\Patient\app\Rules\Cpf;

class ValidateJob implements ShouldQueue
{
    use Dispatchable, Batchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $row) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Validator::validate($this->row, $this->rules());
    }

    private function rules(): array
    {
        return [
            '*.full_name' => [
                'bail',
                'required',
                'string'
            ],
            '*.mothers_full_name' => [
                'bail',
                'required',
                'string'
            ],
            '*.date_of_birth' => [
                'bail',
                'required',
                'date',
                'date_format:d-m-Y'
            ],
            '*.cpf' => [
                'bail',
                'required',
                'string',
                new Cpf()
            ],
            '*.cns' => [
                'bail',
                'required',
                new Cns()
            ]
        ];
    }
}
