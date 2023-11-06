<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:admins,email'],
            'password' => 'required|min:6',
        ]);

        $admin = Admin::whereEmail($request->email)->first();

        if (Hash::check($request->password, $admin->password)) {
            $token = $admin->createToken('Personal access token to apis')->plainTextToken;

            return $this->success("logged in successfully", ['token' => $token, "admin" => new AdminResource($admin)]);

        } else {
            return $this->validationFailure(["password" => [__("Password mismatch")]]);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        return $this->success('You have been successfully logged out!');
    }
}
