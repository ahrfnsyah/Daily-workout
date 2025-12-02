<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    // Get all exercises for API
    public function index()
    {
        return Exercise::orderBy('category')->orderBy('name')->get();
    }
    
    // Get exercises grouped by category (for main page)
    public function grouped()
    {
        return Exercise::all()->groupBy('category');
    }
    
    // Store new exercise
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:exercises,name',
            'category' => 'required|in:chest,back,legs,shoulders,arms,core'
        ]);
        
        $exercise = Exercise::create($validated);
        
        return response()->json([
            'success' => true,
            'data' => $exercise,
            'message' => 'Exercise created successfully'
        ], 201);
    }
    
    // Update exercise
    public function update(Request $request, $id)
    {
        $exercise = Exercise::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:exercises,name,' . $id,
            'category' => 'required|in:chest,back,legs,shoulders,arms,core'
        ]);
        
        $exercise->update($validated);
        
        return response()->json([
            'success' => true,
            'data' => $exercise,
            'message' => 'Exercise updated successfully'
        ]);
    }
    
    // Delete exercise
    public function destroy($id)
    {
        $exercise = Exercise::findOrFail($id);
        $exercise->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Exercise deleted successfully'
        ]);
    }
}