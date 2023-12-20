<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }


    public function showLoginForm()
    {
        return view('auth.admin_login');
    }


    public function login(Request $request)
    {

        $request->validate([
            'email'   => 'required|email|exists:admins',
            'password' => 'required|min:6'
        ]);


        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember_me'))) {

            return redirect()->intended('/dashboard');

        }else
        {
            throw ValidationException::withMessages([
                "password" => __("The password is incorrect"),
            ]);
        }

        return back()->withInput($request->only('email', 'remember'));

    }


    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function forgetPassword()
    {
        return view('auth.forget-password');
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
    }

    public function passwordResetSuccess() 
    {
        return view('auth.password-reset-success');
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
