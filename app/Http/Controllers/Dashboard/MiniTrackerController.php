<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\FileOneImportValidationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMiniTrackerRequest;
use App\Http\Requests\UpdateMiniTrackerRequest;
use App\Imports\SmallFile;
use App\Models\CarNumber;
use App\Models\MiniTracker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

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
        $todayDate = Carbon::now();

        if($carNumber)
        {
            $data['car_number_id'] = $carNumber->id;
        }else{
            $carNumber = CarNumber::create([
                'number' => $request->validated()['car_number']
            ]);

            $data['car_number_id'] = $carNumber->id;
        }
        $data['date'] = $todayDate->toDateString();

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

    public function upload_excel_file(Request $request)
    {
        set_time_limit(1000);

        $this->validate($request, [
            'file' => 'required|mimes:xlsx'
        ]);

        if ($request->hasFile('file')) {
            // store file and save its name
            $file = Storage::disk('public')->putFileAs(
                'miniFiles',
                request()->file('file'),
                uniqid() . "-" . request()->file('file')->getClientOriginalName()
            );

            Excel::import(new SmallFile, storage_path('app/public/' . $file));
            //event(new FileOneImportValidationEvent($file));
        }
    }
}
