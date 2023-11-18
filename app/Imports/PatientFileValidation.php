<?php

namespace App\Imports;


use Illuminate\Bus\Batch;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Patient\app\Jobs\ValidateJob;

class PatientFileValidation implements ToCollection, WithChunkReading, WithHeadingRow, SkipsEmptyRows
{
    use Importable;

    public function __construct(private readonly Batch $batch){}

    public function collection(Collection $rows): void
    {
        $rows = $rows->map(static function ($row) {
            $row['cns'] = (string) $row['cns'];
            return $row;
        });
        $this->batch->add(
            new ValidateJob($rows->toArray())
        );
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
