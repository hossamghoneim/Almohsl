<?php

namespace App\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Facades\Excel;

class FileOneValidationImport implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue
{
    public $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        Excel::import(new FileOneImport, storage_path('app/public/' . $this->file));
    }

    public function chunkSize(): int
    {
        return 10;
    }

}
