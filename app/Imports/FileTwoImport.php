<?php

namespace App\Imports;

use App\Models\BigTracker;
use App\Models\CarNumber;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class FileTwoImport implements ToCollection
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

            BigTracker::create([
                'car_number_id' => $carNumber,
                'vehicle_manufacturer' => $row[$dataHeaders->search('صانع المركبة')],
                'vehicle_model' => $row[$dataHeaders->search('طراز المركبة')],
                'traffic_structure' => $row[$dataHeaders->search('هيكل المرور')],
                'color' => $row[$dataHeaders->search('اللون')],
                'model_year' => $row[$dataHeaders->search('الموديل')],
                'username' => $row[$dataHeaders->search('اسم العميل')],
                'board_registration_type' => $row[$dataHeaders->search('نوع تسجيل اللوحة')] ?? __('لا يوجد'),
                'user_identity' => $row[$dataHeaders->search('هوية المستخدم')],
                'contract_number' => $row[$dataHeaders->search('رقم العقد')],
                'cic' => $row[$dataHeaders->search('CIC')],
                'certificate_status' => $row[$dataHeaders->search('حالة الشهادة')],
                'vehicles_count' => $row[$dataHeaders->search('عدد المركبات')],
                'product' => $row[$dataHeaders->search('المنتج')],
                'installments_count' => $row[$dataHeaders->search('عدد الأقساط')],
                'late_days_count' => $row[$dataHeaders->search('أيام التاخير')],
                'city' => $row[$dataHeaders->search('المدينة')],
                'employer' => $row[$dataHeaders->search('جهة العمل')]
            ]);
        }
    }
}
