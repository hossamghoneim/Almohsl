<?php

namespace App\Imports;

use App\Models\CarNumber;
use App\Models\MiniTracker;
use App\Rules\ValidateCarNumberUniqueness;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;

class FileOneImport implements ToCollection
{

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $validator = Validator::make($collection->toArray(), [
            '*.0' => ['required', new ValidateCarNumberUniqueness(null, $collection->pluck('0')->toArray(), $collection->pluck('4')->toArray(), $collection->pluck('5')->toArray())],
            '*.1' => 'required',
            '*.2' => 'required',
            '*.4' => 'required',
            '*.5' => 'required',
        ], [
            '*.0.required' => __('Car number is required'),
            '*.1.required' => __('Type is required'),
            '*.2.required' => __('Location is required'),
            '*.4.required' => __('Latitude is required'),
            '*.5.required' => __('Longitude is required')
        ])->validate();
        
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
                'lat' => $row[$dataHeaders->search('خط العرض')],
                'lng' => $row[$dataHeaders->search('خط الطول')],
                'date' => Carbon::now()->toDateString(),
            ]);
        }
    }
}
