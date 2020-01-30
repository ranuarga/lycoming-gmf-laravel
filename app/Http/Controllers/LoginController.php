<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginAdmin(Request $request)
    {
        $credentials = [
            'admin_user_name'    => $request->admin_user_name,
            'password' => $request->password
        ];

        try {
            if (! $token = Auth::guard('admin')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }
}
