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

        $admin = auth()->guard('admin')->user();

        return response()->json(array(
            'admin' => $admin,
            'token' => $token
        ));
    }

    public function loginManagement(Request $request)
    {
        $credentials = [
            'management_user_name'    => $request->management_user_name,
            'password' => $request->password
        ];

        try {
            if (! $token = Auth::guard('management')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $management = auth()->guard('management')->user();

        return response()->json(array(
            'management' => $management,
            'token' => $token
        ));
    }

    public function loginEngineer(Request $request)
    {
        $credentials = [
            'engineer_user_name'    => $request->engineer_user_name,
            'password' => $request->password
        ];

        try {
            if (! $token = Auth::guard('engineer')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $engineer = auth()->guard('engineer')->user();

        return response()->json(array(
            'engineer' => $engineer,
            'token' => $token
        ));
    }
}
