<?php

namespace App\Http\Controllers\Admin;

use App\Models\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ManagerController extends Controller
{
    public function index()
    {
        try {
            $managers = Manager::all();
            
            return response()->json([
                'success' => true,
                'data' => $managers
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch managers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|unique:managers',
                'phone' => 'nullable|string|max:20',
                'date_of_birth' => 'nullable|date',
                'language' => 'nullable|string|max:50',
                'gender' => 'nullable|in:male,female,other',
                'marital_status' => 'nullable|in:single,married,divorced,widowed',
                'location' => 'nullable|string|max:100',
                'role' => 'nullable|string|max:100',
                'password' => 'required|min:6',
                'working_experience' => 'nullable|string'
            ]);

            $validated['password'] = Hash::make($validated['password']);
            $manager = Manager::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Manager created successfully',
                'data' => $manager
            ], 201);
            
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create manager',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $manager = Manager::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $manager
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Manager not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $manager = Manager::findOrFail($id);
            
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|unique:managers,email,' . $id,
                'phone' => 'nullable|string|max:20',
                'date_of_birth' => 'nullable|date',
                'language' => 'nullable|string|max:50',
                'gender' => 'nullable|in:male,female,other',
                'marital_status' => 'nullable|in:single,married,divorced,widowed',
                'location' => 'nullable|string|max:100',
                'role' => 'nullable|string|max:100',
                'working_experience' => 'nullable|string'
            ]);

            if ($request->filled('password')) {
                $validated['password'] = Hash::make($request->password);
            }

            $manager->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Manager updated successfully',
                'data' => $manager
            ], 200);
            
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update manager',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $manager = Manager::findOrFail($id);
            $manager->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Manager deleted successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete manager',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}