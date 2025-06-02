<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseManager;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CaseManagerController extends Controller
{
    public function index()
    {
        try {
            $caseManagers = CaseManager::all();
            return response()->json($caseManagers);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'Database connection error',
                'message' => 'Could not connect to the database. Please try again later.',
                'code' => $e->getCode()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                // Add other validation rules as needed
            ]);
            
            $caseManager = CaseManager::create($validated);
            return response()->json($caseManager, 201);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database connection error'], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $caseManager = CaseManager::findOrFail($id);
            return response()->json($caseManager);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Case manager not found'], 404);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'Database connection error',
                'message' => 'Could not connect to the database. Please try again later.',
                'code' => $e->getCode()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $caseManager = CaseManager::findOrFail($id);
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                // Add other validation rules as needed
            ]);
            
            $caseManager->update($validated);
            return response()->json($caseManager);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Case manager not found'], 404);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'Database connection error',
                'message' => 'Could not connect to the database. Please try again later.',
                'code' => $e->getCode()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $caseManager = CaseManager::findOrFail($id);
            $caseManager->delete();
            return response()->json(null, 204);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database connection error'], 500);
        }
    }
}
