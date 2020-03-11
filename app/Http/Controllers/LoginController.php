<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginForm()
    {
        if(!Auth::guard('web-admin')->check())
            return view('home.login');
        else
            return redirect('home');
    }

    public function loginWeb(Request $request)
    {
        $this->validate($request, [
            'admin_user_name' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'admin_user_name'    => $request->admin_user_name,
            'password' => $request->password
        ];

        if (Auth::guard('web-admin')->attempt($credentials)) {
            return redirect('home');
        }

        return redirect('login')->with('error', 'Invalid Username or Password');
    }

    public function logoutWeb(Request $request)
    {
        if (Auth::guard('web-admin')->check()) {
            Auth::guard('web-admin')->logout();
            $request->session()->invalidate();
        }
        return redirect('login');
    }

    public function loginAdmin(Request $request)
    {
        $credentials = [
            'admin_user_name'    => $request->admin_user_name,
            'password' => $request->password
        ];

        try {
            if (! $token = Auth::guard('admin')->attempt($credentials)) {
                return response()->json(['message' => 'Invalid username or password'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'could_not_create_token'], 500);
        }

        $admin = auth()->guard('admin')->user();
        $admin['token'] = $token;

        return response()->json(array(
            'admin' => $admin,
            'message' => 'Login Success'
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
                return response()->json(['message' => 'Invalid username or password'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'could_not_create_token'], 500);
        }

        $management = auth()->guard('management')->user();
        $management['token'] = $token;

        return response()->json(array(
            'management' => $management,
            'message' => 'Login Success'
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
                return response()->json(['message' => 'Invalid username or password'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'could_not_create_token'], 500);
        }

        $engineer = auth()->guard('engineer')->user();
        $engineer['token'] = $token;

        return response()->json(array(
            'engineer' => $engineer,
            'message' => 'Login Success'
        ));
    }
}
