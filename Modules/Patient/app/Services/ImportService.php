<?php

namespace Modules\Patient\app\Services;

use App\Imports\PatientFileValidation;
use App\Imports\PatientsImport;
use App\Models\User;
use Illuminate\Bus\Batch;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Modules\Patient\app\Emails\FileImportFails;
use Modules\Patient\app\Emails\FileImportSuccess;
use Modules\Patient\app\Emails\FileValidationFailed;

class ImportService
{
    private string $file_path;
    private User $user;

    /**
     * @throws \Throwable
     */
    public function import(UploadedFile $file, User $user): void
    {
        $this->file_path = $this->saveFile($file);

        $this->user = $user;

        $batch = $this->dispatchBatchForValidation();

        $validation = new PatientFileValidation($batch);

        $validation->import($this->file_path);
    }

    /**
     * @throws \Throwable
     */
    private function dispatchBatchForValidation(): Batch
    {
        $user = $this->user;

        return Bus::batch([])
            ->allowFailures()
            ->finally(function (Batch $batch) use($user) {
                if ($batch->failedJobs === 0) {
                   $this->runMassInsertion();
                } else {
                    Mail::to($user)->send(new FileValidationFailed($user));
                }
            })
            ->name('Patients data validation.')
            ->dispatch();
    }

    /**
     * @throws \Throwable
     */
    private function runMassInsertion(): void
    {
        $import = new PatientsImport($this->dispatchBatchForImport());

        $import->import($this->file_path);
    }

    /**
     * @throws \Throwable
     */
    public function dispatchBatchForImport(): Batch
    {
        $user = $this->user;

        return Bus::batch([])
            ->allowFailures()
            ->finally(function (Batch $batch) use ($user){
                if($batch->failedJobs === 0){
                    Mail::to($user)->send(new FileImportSuccess($user));
                }else{
                    Mail::to($user)->send(new FileImportFails($user));
                }
            })
            ->dispatch();
    }

    /**
     * @throws \Throwable
     */
    private function saveFile(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();

        do {
            $filename = \Str::random().'.'.$extension;
        } while (\Storage::exists("import_patients/{$filename}"));

        $path = $file->storeAs('import_patients', $filename);

        throw_if($path === FALSE, new \RuntimeException('Erro ao tentar salvar arquivo', 400));

        return $path;
    }
}
