<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\FileTwoImportValidationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBigTrackerRequest;
use App\Models\BigTracker;
use App\Models\CarNumber;
use App\Models\MiniTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BigTrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $data = getModelData( model: new BigTracker(), relations: ['carNumber' => ['id', 'number']]);
            return response()->json($data);
        }

        return view('dashboard.big-trackers.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBigTrackerRequest $request, string $id)
    {
        $bigTracker = BigTracker::findOrFail($id);
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

        $bigTracker->update($data);
    }

    public function show(string $id)
    {

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
        $this->validate($request, [
            'file' => 'required|mimes:xlsx'
        ]);

        if ($request->hasFile('file')) {
            // store file and save its name
            $file = Storage::disk('public')->putFileAs(
                'bigFiles',
                request()->file('file'),
                uniqid() . "-" . request()->file('file')->getClientOriginalName()
            );

            event(new FileTwoImportValidationEvent($file));
        }
    }
}