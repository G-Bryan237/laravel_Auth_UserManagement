<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller 
{
    public function index() { return Category::all(); }
    
    public function store(Request $request) {
        $request->validate(['name' => 'required']);
        return Category::create($request->all());
    }
    
    public function show($id) { return Category::findOrFail($id); }
    
    public function update(Request $request, $id) {
        $category = Category::findOrFail($id);
        $category->update($request->all());
        return $category;
    }
    
    public function destroy($id) { return Category::destroy($id); }
}
