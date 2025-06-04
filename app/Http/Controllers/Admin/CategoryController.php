<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller 
{
    public function index() 
    { 
        try {
            $categories = Category::with('country')->get();
            
            return response()->json([
                'success' => true,
                'data' => $categories
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function store(Request $request) 
    {
        try {
            $validated = $request->validate([
                'CategoryName' => 'required|string|max:100',
                'CountryCode' => 'required|string|max:10|exists:Country,CountryCode'
            ]);

            $category = Category::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'data' => $category->load('country')
            ], 201);
            
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create category',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function show($id) 
    { 
        try {
            $category = Category::with('country')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $category
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
    
    public function update(Request $request, $id) 
    {
        try {
            $category = Category::findOrFail($id);
            
            $validated = $request->validate([
                'CategoryName' => 'required|string|max:100',
                'CountryCode' => 'required|string|max:10|exists:Country,CountryCode'
            ]);
            
            $category->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully',
                'data' => $category->load('country')
            ], 200);
            
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update category',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function destroy($id) 
    { 
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
