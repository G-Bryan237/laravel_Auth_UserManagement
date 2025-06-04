<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SpecialtyController extends Controller
{
    public function index()
    {
        try {
            $specialties = Specialty::with(['school', 'schoolClass'])->get();
            
            return response()->json([
                'success' => true,
                'data' => $specialties
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch specialties',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'SpecialtyName' => 'required|string|max:100',
                'Description' => 'nullable|string',
                'SchoolID' => 'required|integer|exists:schools,SchoolID',
                'ClassID' => 'required|integer|exists:school_classes,id'
            ]);

            $specialty = Specialty::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Specialty created successfully',
                'data' => $specialty->load(['school', 'schoolClass'])
            ], 201);
            
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create specialty',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $specialty = Specialty::with(['school', 'schoolClass'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $specialty
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Specialty not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $specialty = Specialty::findOrFail($id);
            
            $validated = $request->validate([
                'SpecialtyName' => 'required|string|max:100',
                'Description' => 'nullable|string',
                'SchoolID' => 'required|integer|exists:schools,SchoolID',
                'ClassID' => 'required|integer|exists:school_classes,id'
            ]);

            $specialty->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Specialty updated successfully',
                'data' => $specialty->load(['school', 'schoolClass'])
            ], 200);
            
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update specialty',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $specialty = Specialty::findOrFail($id);
            $specialty->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Specialty deleted successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete specialty',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
