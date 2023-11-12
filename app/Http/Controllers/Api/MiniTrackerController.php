<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMiniTrackerRequest;
use App\Http\Resources\MiniTrackerResource;
use App\Models\CarNumber;
use App\Models\MiniTracker;
use Illuminate\Http\Request;

class MiniTrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $miniTrackers = MiniTracker::with('carNumber')->paginate(6);

        return $this->successWithPagination("miniTrackers", MiniTrackerResource::collection($miniTrackers)->response()->getData(true));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMiniTrackerRequest $request)
    {
        $data = $request->except('car_number');
        $carNumber = CarNumber::where('number', $request->validated()['car_number'])->first();

        if($carNumber)
        {
            $data['car_number_id'] = $carNumber->id;
        }else{
            $carNumber = CarNumber::create([
                'number' => $request->validated()['car_number']
            ]);

            $data['car_number_id'] = $carNumber->id;
        }

        MiniTracker::create($data);

        return $this->success('Data created successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $miniTracker = MiniTracker::findOrFail($id);

        $miniTracker->delete();

        return $this->success('Data deleted successfully');
    }
}
