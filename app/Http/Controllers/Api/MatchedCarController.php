<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MatchedCarResource;
use App\Models\MatchedCar;
use App\Models\MiniTracker;

class MatchedCarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $matchedData = MatchedCar::paginate(6);

        return $this->successWithPagination("matchedData", MatchedCarResource::collection($matchedData)->response()->getData(true));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $matchedCar = MatchedCar::findOrFail($id);

        $matchedCar->delete();

        return $this->success('Data deleted successfully');
    }
}
