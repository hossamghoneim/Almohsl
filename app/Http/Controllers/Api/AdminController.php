<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::where('email', '!=', 'support@test.com')->get();
        
        return $this->success("", AdminResource::collection($admins));
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

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => "required|email:255|exists:admins,email",
        ]);

        $newPassword = $this->randomPassword();

        Admin::where('email', $request->email)->first()->update([
            'password' => $newPassword
        ]);
        
        Mail::send('mails.reset-password',['newPassword' =>  $newPassword],function($message) use($request){
            $message->to($request->email)->subject('reset password'); 
        });

        return response()->json([
            'message' => 'Password was sent successfully',
            'code' => 200,
        ], 200);
    }

    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
