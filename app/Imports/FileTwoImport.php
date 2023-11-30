<?php

namespace App\Imports;

use App\Models\BigTracker;
use App\Models\CarNumber;
use App\Models\MatchedCar;
use App\Models\MiniTracker;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;

class FileTwoImport implements ToCollection
{

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $validator = Validator::make($collection->toArray(), [
            '*.1' => ['required'],
        ], [
            '*.1.required' => __('Car number is required'),
        ])->validate();
        
        // filter headers for take only columns with data
        $dataHeaders = $collection[0]->filter(function ($value) {
            return $value != null;
        });

        // arrange collection to get only rows with inserted data (ignore the headings)
        $collection->forget(0);

        foreach ($collection as  $row) {

            if ($row[$dataHeaders->search('اللوحة')] == null) {
                continue;
            }

            $carNumber = CarNumber::where('number', $row[$dataHeaders->search('اللوحة')])->first();

            if($carNumber)
            {
                $carNumber = $carNumber->id;
            }else{
                $carNumber = CarNumber::create([
                    'number' => $row[$dataHeaders->search('اللوحة')]
                ]);

                $carNumber = $carNumber->id;
            }

            $bigTracker = BigTracker::create([
                'car_number_id' => $carNumber,
                'source' => $row[$dataHeaders->search('المصدر')],
                'vehicle_manufacturer' => $row[$dataHeaders->search('صانع المركبة')],
                'vehicle_model' => $row[$dataHeaders->search('طراز المركبة')],
                'traffic_structure' => $row[$dataHeaders->search('هيكل المرور')],
                'color' => $row[$dataHeaders->search('اللون')],
                'model_year' => $row[$dataHeaders->search('الموديل ')],
                'username' => $row[$dataHeaders->search('اسم العميل')],
                'board_registration_type' => $row[$dataHeaders->search('نوع تسجيل اللوحة')] ?? __('لا يوجد'),
                'user_identity' => $row[$dataHeaders->search('هوية المستخدم')],
                'contract_number' => $row[$dataHeaders->search('رقم العقد ')],
                'cic' => $row[$dataHeaders->search('   CIC    ')],
                'certificate_status' => $row[$dataHeaders->search('حالة الشهادة ')],
                'vehicles_count' => $row[$dataHeaders->search('عدد المركبات')],
                'product' => $row[$dataHeaders->search('المنتج')],
                'installments_count' => $row[$dataHeaders->search('عدد الأقساط')],
                'late_days_count' => $row[$dataHeaders->search('أيام التاخير ')],
                'city' => $row[$dataHeaders->search('المدينة')],
                'employer' => $row[$dataHeaders->search('جهة العمل')]
            ]);

            $miniTrackers = MiniTracker::with('carNumber')->where('car_number_id', $carNumber)->get();
            foreach($miniTrackers as $miniTracker)
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
                    'type' => $miniTracker->type,
                    'location' => $miniTracker->location,
                    'district' => $miniTracker->district,
                    'url' => $miniTracker->url,
                ]);
            }

        }
    }
}
