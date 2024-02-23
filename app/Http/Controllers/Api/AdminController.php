<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Hash;
use Illuminate\Support\Facades\Auth;
use Validator;

class AdminController extends Controller
{
    public function loginRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'type' => 'required',
            'mobile' => 'required|numeric|digits:11',
            'email' => 'required', 
            'password' => 'required|min:8|max:100',
            'confirm' => 'required|in:Yes,No',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status' => 'failed',
                'errors' => $validator->messages(),
            ], 422);
        }
        
        if (Admin::where('email', $request->email)->first()) { 
            return response()->json([
                'message' => 'Email already exists',
                'status' => 'failed',
            ], 200);
        }
        
        $admin = Admin::create([
            'name' => $request->name,
            'type' => $request->type, 
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'confirm' => $request->confirm, 
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        return response()->json([
            'message' => 'Admin Registration Success',
            'status' => 'success',
            'admin' => $admin,
        ], 201);
    }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

    
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $admin = Auth::guard('admin'); // Use Auth::guard('admin')->user() to get the authenticated admin
            return response()->json([
                'message' => 'Login successful',
                'status' => 'success',
                'admin' => $admin,
            ], 200);
        }


        return response()->json([
            'message' => 'Invalid credentials',
            'status' => 'failed',
        ], 401);
    }

}
