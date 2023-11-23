<?php

namespace App\Imports;

use App\Models\BigTracker;
use App\Models\CarNumber;
use App\Models\MatchedCar;
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
            '*.6' => 'required',
        ], [
            '*.0.required' => __('Car number is required'),
            '*.1.required' => __('Type is required'),
            '*.2.required' => __('Location is required'),
            '*.4.required' => __('Latitude is required'),
            '*.5.required' => __('Longitude is required'),
            '*.6.required' => __('URL is required')
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
                'url' => $row[$dataHeaders->search('الرابط')],
            ]);

            $bigTrackers = BigTracker::with('carNumber')->where('car_number_id', $carNumber)->get();
            foreach($bigTrackers as $bigTracker)
            {
                MatchedCar::create([
                    'car_number' => $bigTracker->carNumber->number,
                    'vehicle_manufacturer' => $bigTracker->vehicle_manufacturer,
                    'source' => $bigTracker->source,
                    'vehicle_model' => $bigTracker->vehicle_model,
                    'traffic_structure' => $bigTracker->traffic_structure,
                    'color' => $bigTracker->color,
                    'model_year' => $bigTracker->model_year,
                    'username' => $bigTracker->username,
                    'board_registration_type' => $bigTracker->board_registration_type,
                    'user_identity' => $bigTracker->user_identity,
                    'contract_number' => $bigTracker->contract_number,
                    'cic' => $bigTracker->cic,
                    'certificate_status' => $bigTracker->certificate_status,
                    'vehicles_count' => $bigTracker->vehicles_count,
                    'product' => $bigTracker->product,
                    'installments_count' => $bigTracker->installments_count,
                    'late_days_count' => $bigTracker->late_days_count,
                    'city' => $bigTracker->city,
                    'employer' => $bigTracker->employer,
                    'type' => $row[$dataHeaders->search('النوع')],
                    'location' => $row[$dataHeaders->search('الموقع')],
                    'district' => $row[$dataHeaders->search('الحي')],
                    'lat' => $row[$dataHeaders->search('خط العرض')],
                    'lng' => $row[$dataHeaders->search('خط الطول')],
                    'url' => $row[$dataHeaders->search('الرابط')],
                ]);
            }
        }
    }
}
