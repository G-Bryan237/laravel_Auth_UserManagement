<?php

namespace App\Http\Controllers\Admin;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegionController extends Controller 
{
    public function index() 
    { 
        return Region::with('country')->get(); 
    }

    public function store(Request $request) 
    {
        try {
            $validated = $request->validate([
                'RegionName' => 'required|string|max:100',
                // Remove CountryCode from validation - make it automatic
            ]);

            // Auto-assign country code (example: from admin's profile or system default)
            $admin = Auth::user();
            $validated['CountryCode'] = $admin->CountryCode ?? 'US'; // Default to US if not set

            $region = Region::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Region created successfully',
                'data' => $region->load('country')
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create region',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id) 
    { 
        return Region::findOrFail($id); 
    }

    public function update(Request $request, $id) 
    {
        $region = Region::findOrFail($id);
        $region->update($request->all());
        return $region;
    }

    public function destroy($id) 
    { 
        return Region::destroy($id); 
    }
}
