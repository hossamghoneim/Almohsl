<?php

namespace App\Http\Controllers\Api;

use App\Events\FileTwoImportValidationEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\BigTrackerResource;
use App\Imports\BigFile;
use App\Models\BigTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BigTrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bigTrackers = BigTracker::with('carNumber')->paginate(6);

        return $this->successWithPagination("bigTrackers", BigTrackerResource::collection($bigTrackers)->response()->getData(true));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bigTracker = BigTracker::findOrFail($id);

        $bigTracker->delete();

        return $this->success('Data deleted successfully');
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

            //event(new FileTwoImportValidationEvent($file));
            Excel::import(new BigFile, storage_path('app/public/' . $file));

            $bigTrackers = BigTracker::with('carNumber')->latest()->paginate(6);

            return $this->successWithPagination("File uploaded successfully", BigTrackerResource::collection($bigTrackers)->response()->getData(true));
        }

        return $this->failure('Error has been occurred while uploading, try again later');
    }
}
