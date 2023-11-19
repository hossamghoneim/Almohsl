<?php

namespace App\Rules;

use App\Models\CarNumber;
use App\Models\MiniTracker;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateCarNumberUniqueness implements ValidationRule
{
    private $carsGroup;
    private $latsGroup;
    private $lngsGroup;
    private $miniTrackerID;

    public function __construct($miniTrackerID = null, $carsGroup = null, $latsGroup = null, $lngsGroup = null) 
    {
        $this->carsGroup = $carsGroup;
        $this->latsGroup = $latsGroup;
        $this->lngsGroup = $lngsGroup;
        $this->miniTrackerID = $miniTrackerID;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($this->carsGroup)
        {
            $carNumber = CarNumber::where('number', $value)->first();
            if($carNumber)
            {
                $miniTrackers = MiniTracker::where('car_number_id', $carNumber->id)
                    ->where('date', Carbon::now()->toDateString())
                    ->get();
                
                foreach($miniTrackers as $miniTracker)
                {
                    $foundCar = collect($this->carsGroup)->contains($carNumber->number); 
                    $foundLat = collect($this->latsGroup)->contains($miniTracker->lat);
                    $foundLng = collect($this->lngsGroup)->contains($miniTracker->lng);

                    if($foundCar && $foundLat && $foundLng)
                    {
                        $fail(__('Car number ') . $value . __(' has already been taken'));
                    }
                }
            }
        }else{
            $carNumber = CarNumber::where('number', request()->car_number)->first();
            if($carNumber)
            {
                if($this->miniTrackerID)
                {
                    if(MiniTracker::where('id', '!=', $this->miniTrackerID)->where('car_number_id', $carNumber->id)->where('date', Carbon::now()->toDateString())->where('lat', request()->lat)->where('lng', request()->lng)->first())
                    {
                        $fail(__('Car number ') . $value . __(' has already been taken'));
                    }
                }else{
                    if(MiniTracker::where('car_number_id', $carNumber->id)->where('date', Carbon::now()->toDateString())->where('lat', request()->lat)->where('lng', request()->lng)->first())
                    {
                        $fail(__('Car number ') . $value . __(' has already been taken'));
                    }
                }
            }
        }
        
    }
}
