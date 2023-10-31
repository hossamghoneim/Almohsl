<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
}
