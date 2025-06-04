<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CaseManagerController extends Controller
{
    public function index()
    {
        try {
            $caseManagers = CaseManager::all();
            
            return response()->json([
                'success' => true,
                'data' => $caseManagers
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch case managers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|unique:case_managers',
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
            $caseManager = CaseManager::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Case manager created successfully',
                'data' => $caseManager
            ], 201);
            
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create case manager',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $caseManager = CaseManager::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $caseManager
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Case manager not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $caseManager = CaseManager::findOrFail($id);
            
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|unique:case_managers,email,' . $id,
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

            $caseManager->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Case manager updated successfully',
                'data' => $caseManager
            ], 200);
            
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update case manager',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $caseManager = CaseManager::findOrFail($id);
            $caseManager->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Case manager deleted successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete case manager',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
