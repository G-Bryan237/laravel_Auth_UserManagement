<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $schools = School::with(['region', 'category', 'manager'])->get();
            
            return response()->json([
                'success' => true,
                'data' => $schools
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch schools',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'SchoolName' => 'required|string|max:200',
                'SchoolCounty' => 'nullable|string|max:100',
                'RegionID' => 'required|integer|exists:regions,RegionID',
                'CategoryID' => 'required|integer|exists:categories,CategoryID',
                'Location' => 'nullable|string|max:200',
                'ManagerID' => 'nullable|integer|exists:managers,id'
            ]);

            $school = School::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'School created successfully',
                'data' => $school->load(['region', 'category', 'manager'])
            ], 201);
            
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create school',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $school = School::with(['region', 'category', 'manager', 'classes', 'specialities'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $school
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'School not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $school = School::findOrFail($id);
            
            $validated = $request->validate([
                'SchoolName' => 'required|string|max:200',
                'SchoolCounty' => 'nullable|string|max:100',
                'RegionID' => 'required|integer|exists:regions,RegionID',
                'CategoryID' => 'required|integer|exists:categories,CategoryID',
                'Location' => 'nullable|string|max:200',
                'ManagerID' => 'nullable|integer|exists:managers,id'
            ]);

            $school->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'School updated successfully',
                'data' => $school->load(['region', 'category', 'manager'])
            ], 200);
            
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update school',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $school = School::findOrFail($id);
            $school->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'School deleted successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete school',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
