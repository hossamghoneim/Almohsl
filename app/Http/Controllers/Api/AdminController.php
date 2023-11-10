<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::where('email', '!=', 'support@test.com')->get();
        
        return $this->success("", ["admins" => AdminResource::collection($admins)]);
    }

    public function store(StoreAdminRequest $request)
    {
        $data           = $request->validated();
        $data['status'] = ( bool ) request('status');
        Admin::create($data);

        return $this->success('Admin created successfully');
    }


    public function updateInfo(UpdateAdminRequest $request)
    {
        $admin = auth()->user();
        $admin->update($request->validated());

        return $this->success("Updated successfully");
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'password'              => ['required','string','min:6','max:255','confirmed'],
            'password_confirmation' => ['required','same:password'],
        ]);

        auth()->user()->update($data);

        return $this->success("Updated successfully");
    }

    public function show()
    {
        return $this->success("", new AdminResource(auth()->user()));
    }

    public function destroy(Request $request, Admin $admin)
    {
        $admin->delete();

        return $this->success("Deleted successfully");
    }
}
