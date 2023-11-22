<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\FileOneImportValidationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMiniTrackerRequest;
use App\Http\Requests\UpdateMiniTrackerRequest;
use App\Models\CarNumber;
use App\Models\MatchedCar;
use App\Models\MiniTracker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MatchedCarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $data = getModelData( model: new MatchedCar() );
            return response()->json($data);
        }

        return view('dashboard.matched-cars.index');
    }

    public function show(MatchedCar $matchedCar)
    {
        return view('dashboard.matched-cars.show', compact('matchedCar'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $matchedCar = MatchedCar::findOrFail($id);

        $matchedCar->delete();
    }

    public function deleteSelected(Request $request)
    {
        MatchedCar::whereIn('id', $request->selected_items_ids)->delete();
        
        return response(["selected matched data deleted successfully"]);
    }

}
