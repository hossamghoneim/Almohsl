<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMiniTrackerRequest;
use App\Http\Requests\UpdateMiniTrackerRequest;
use App\Models\CarNumber;
use App\Models\MiniTracker;
use Illuminate\Http\Request;

class MiniTrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $data = getModelData( model: new MiniTracker(), relations: ['carNumber' => ['id', 'number']]);
            return response()->json($data);
        }

        return view('dashboard.mini-trackers.index');
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMiniTrackerRequest $request, string $id)
    {
        $miniTracker = MiniTracker::findOrFail($id);
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

        $miniTracker->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $miniTracker = MiniTracker::findOrFail($id);

        $miniTracker->delete();
    }

    public function deleteSelected(Request $request)
    {
        MiniTracker::whereIn('id', $request->selected_items_ids)->delete();
        
        return response(["selected mini trackers deleted successfully"]);
    }
}
