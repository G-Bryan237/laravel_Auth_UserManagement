<?php

namespace App\Http\Controllers\Admin;

use App\Models\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    public function index()
    {
        return Manager::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:managers',
            'phone' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'language' => 'nullable|string',
            'gender' => 'nullable|in:male,female,other',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'location' => 'nullable|string',
            'role' => 'nullable|string',
            'password' => 'required|min:6',
            'working_experience' => 'nullable|string'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        return Manager::create($validated);
    }

    public function show($id)
    {
        return Manager::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $manager = Manager::findOrFail($id);
        
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:managers,email,' . $id,
            'phone' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'language' => 'nullable|string',
            'gender' => 'nullable|in:male,female,other',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'location' => 'nullable|string',
            'role' => 'nullable|string',
            'working_experience' => 'nullable|string'
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $manager->update($validated);
        return $manager;
    }

    public function destroy($id)
    {
        return Manager::destroy($id);
    }
}
