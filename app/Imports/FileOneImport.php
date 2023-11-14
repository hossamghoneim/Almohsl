<?php

namespace App\Imports;

use App\Models\CarNumber;
use App\Models\MiniTracker;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class FileOneImport implements ToCollection
{

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {

        // filter headers for take only columns with data
        $dataHeaders = $collection[0]->filter(function ($value) {
            return $value != null;
        });

        // arrange collection to get only rows with inserted data (ignore the headings)
        $collection->forget(0);

        foreach ($collection as  $row) {

            if ($row[$dataHeaders->search('اللوحه')] == null) {
                continue;
            }

            $carNumber = CarNumber::where('number', $row[$dataHeaders->search('اللوحه')])->first();

            if($carNumber)
            {
                $carNumber = $carNumber->id;
            }else{
                $carNumber = CarNumber::create([
                    'number' => $row[$dataHeaders->search('اللوحه')]
                ]);

                $carNumber = $carNumber->id;
            }

            MiniTracker::create([
                'car_number_id' => $carNumber,
                'type' => $row[$dataHeaders->search('النوع')],
                'location' => $row[$dataHeaders->search('الموقع')],
                'district' => $row[$dataHeaders->search('الحي')],
            ]);
        }
    }
}
