<?php

namespace App\Listeners;

use App\Imports\FileTwoValidationImport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Facades\Excel;

class RunFileTwoImportValidations implements ShouldQueue
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
        Excel::import(new FileTwoValidationImport($event->file), storage_path('app/public/' . $event->file));
    }
}
