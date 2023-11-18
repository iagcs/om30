<?php

namespace App\Imports;

use Illuminate\Bus\Batch;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Patient\app\Jobs\ImportJob;

class PatientsImport implements ToCollection, WithChunkReading, WithHeadingRow, SkipsEmptyRows
{
    use Importable;

    public function __construct(private readonly Batch $batch) {}

    public function collection(Collection $rows): void
    {
        $rows = $this->formatDataForMassInsertion($rows);

        $this->batch->add(
            new ImportJob($rows->toArray())
        );
    }

    private function formatDataForMassInsertion(Collection $rows): Collection
    {
        return $rows->map(static function ($row) {
            $row['id'] = fake()->unique()->uuid;
            $row['cns'] = (string) $row['cns'];
            $row['created_at'] = now();
            $row['updated_at'] = now();
            return $row;
        });
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
