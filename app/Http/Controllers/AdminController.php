<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function registerStart(Request $request)
    {
        try {
            $validated = $request->validate([
                'FullName' => 'required|string|max:100',
                'Email' => 'required|string|email|unique:Admin',
                'PhoneNumber' => 'required|string|max:20',
                'Whatsapp' => 'nullable|string|max:20',
                'AcademicRecord' => 'required|string',
                'Password' => 'required|string|min:8'

            ]);

            $admin = Admin::create([
                'FullName' => $validated['FullName'],
                'Email' => $validated['Email'],
                'PhoneNumber' => $validated['PhoneNumber'],
                'Whatsapp' => $validated['Whatsapp'],
                'AcademicRecord' => $validated['AcademicRecord'],
                'Password' => Hash::make($validated['Password'])

            ]);

            $token = $admin->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'First step completed',
                'token' => $token,
                'admin' => $admin
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function registerNext(Request $request)
    {
        try {
            $validated = $request->validate([
                'Language' => 'required|string|max:50',
                'Gender' => 'required|string|max:10',
                'MaritalStatus' => 'required|string|max:20',
                'Location' => 'required|string|max:100',
                'WorkExperience' => 'required|string'
            ]);

            $admin = Auth::user();
            
            Admin::where('AdminID', $admin->AdminID)->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Registration completed successfully',
                'admin' => Admin::find($admin->AdminID)
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'Email' => 'required|email',
                'Password' => 'required|string'
            ]);

            $admin = Admin::where('Email', $validated['Email'])->first();

            if (!$admin || !Hash::check($validated['Password'], $admin->Password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            $token = $admin->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'token' => $token,
                'admin' => $admin
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function profile(Request $request)
    {
        try {
            $admin = Auth::user();
            
            return response()->json([
                'success' => true,
                'admin' => $admin
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            // Revoke the current access token
            $request->user()->currentAccessToken()->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logout failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
