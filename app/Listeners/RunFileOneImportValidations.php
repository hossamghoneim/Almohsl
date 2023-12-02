<?php

namespace App\Listeners;

use App\Imports\FileOneValidationImport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Facades\Excel;

class RunFileOneImportValidations implements ShouldQueue, WithChunkReading
{
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event): void
    {
        Excel::import(new FileOneValidationImport($event->file), storage_path('app/public/' . $event->file));
    }

    public function chunkSize(): int
    {
        return 10;
    }
}
