<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function index()
    {
        return Specialty::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string'
        ]);

        return Specialty::create($request->all());
    }

    public function show($id)
    {
        return Specialty::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $specialty = Specialty::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string'
        ]);

        $specialty->update($request->all());
        return $specialty;
    }

    public function destroy($id)
    {
        return Specialty::destroy($id);
    }
}
