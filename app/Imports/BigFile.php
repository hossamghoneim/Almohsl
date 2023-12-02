<?php

namespace App\Imports;

use App\Models\BigTracker;
use App\Models\CarNumber;
use App\Models\MatchedCar;
use App\Models\MiniTracker;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none'); 

class BigFile implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithUpserts, WithEvents, SkipsEmptyRows
{
    use RegistersEventListeners;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    { 
        $validator = Validator::make($row, [
            'المصدر' => ['required'],
            'صانع المركبة' => ['required'],
            'طراز المركبة' => ['required'],
            'هيكل المرور' => ['required'],
        ])->validate();

        $row = array_filter($row);

        if (!isset($row['اللوحة'])) 
        {
            return null;
        }

        $carNumber = CarNumber::where('number', $row['اللوحة'])->first();

        if($carNumber)
        {
            $carNumber = $carNumber->id;
        }else{
            $carNumber = CarNumber::create([
                'number' => $row['اللوحة']
            ]);

            $carNumber = $carNumber->id;
        }

        return new BigTracker([
            'car_number_id' => $carNumber,
            'source' => $row['المصدر'],
            'vehicle_manufacturer' => $row['صانع المركبة'],
            'vehicle_model' => $row['طراز المركبة'],
            'traffic_structure' => $row['هيكل المرور'],
            'color' => $row['اللون'],
            'model_year' => $row['الموديل '],
            'username' => $row['اسم العميل'],
            'board_registration_type' => $row['نوع تسجيل اللوحة'] ?? __('لا يوجد'),
            'user_identity' => $row['هوية المستخدم'],
            'contract_number' => $row['رقم العقد '],
            'cic' => $row['   CIC    '],
            'certificate_status' => $row['حالة الشهادة '],
            'vehicles_count' => $row['عدد المركبات'],
            'product' => $row['المنتج '],
            'installments_count' => $row['عدد الأقساط'],
            'late_days_count' => $row['أيام التاخير '],
            'city' => $row['المدينة'],
            'employer' => $row['جهة العمل']
        ]);
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function uniqueBy()
    {
        return ['car_number_id', 'vehicle_model'];
    }

    public function afterImport(AfterImport $event)
    {
        $miniTrackers = MiniTracker::chunk(100, function ($miniTrackers) {
            foreach ($miniTrackers as $miniTracker) 
            {
                // Process each miniTracker
                BigTracker::where('car_number_id', $miniTracker->car_number_id)->with('carNumber')->chunk(100, function($bigTrackers) use($miniTracker){
                    foreach($bigTrackers as $bigTracker)
                    {
                        MatchedCar::updateOrCreate(
                            [
                                'car_number' => $bigTracker->carNumber->number,
                                'vehicle_manufacturer' => $bigTracker->vehicle_manufacturer,
                                'url' => $miniTracker->url,
                            ],
                            [
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
                });
            }
        });
    }
}
