<?php

namespace App\Http\Controllers;

use App\Models\WorkoutResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkoutResultController extends Controller
{
   public function index(Request $request)
{
    $query = WorkoutResult::with('exercise');
    
    if ($request->has('start') && $request->has('end')) {
        $query->whereBetween('date', [$request->start, $request->end]);
    }
    
    return $query->get()->map(function($result) {
        return [
            'id' => $result->id,
            'title' => $result->exercise->name,
            'start' => $result->date->format('Y-m-d'),
            'allDay' => true,
            'className' => 'event-' . $result->exercise->category, // Add class for styling
            'extendedProps' => [
                'exercise_id' => $result->exercise_id,
                'exercise_name' => $result->exercise->name,
                'category' => $result->exercise->category,
                'sets' => $result->sets,
                'reps' => $result->reps,
                'total_reps' => $result->sets * $result->reps
            ]
        ];
    });
}

// Helper function untuk warna berdasarkan kategori
private function getCategoryColor($category)
{
    $colors = [
        'chest' => '#ff6b6b',    // Red
        'back' => '#48dbfb',     // Blue
        'legs' => '#1dd1a1',     // Green
        'shoulders' => '#feca57', // Yellow
        'arms' => '#ff9ff3',     // Pink
        'core' => '#54a0ff',     // Light Blue
    ];
    
    return $colors[$category] ?? '#3498db'; // Default blue
}
    
   public function store(Request $request)
{
    try {
        \Log::info('WorkoutResult Store Request:', $request->all());
        
        $validated = $request->validate([
            'exercise_id' => 'required|exists:exercises,id',
            'date' => 'required|date',
            'sets' => 'required|integer|min:1|max:50',
            'reps' => 'required|integer|min:1|max:200'
        ]);
        
        \Log::info('Validated Data:', $validated);
        
        // Cek jika sudah ada di tanggal yang sama
        $existing = WorkoutResult::where('exercise_id', $validated['exercise_id'])
            ->where('date', $validated['date'])
            ->first();
            
        if ($existing) {
            $existing->update($validated);
            \Log::info('Updated existing workout:', $existing->toArray());
            return response()->json([
                'success' => true,
                'data' => $existing,
                'message' => 'Workout updated successfully'
            ], 200);
        }
        
        $workout = WorkoutResult::create($validated);
        \Log::info('Created new workout:', $workout->toArray());
        
        return response()->json([
            'success' => true,
            'data' => $workout,
            'message' => 'Workout saved successfully'
        ], 201);
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error('Validation Error:', $e->errors());
        return response()->json([
            'success' => false,
            'errors' => $e->errors(),
            'message' => 'Validation failed'
        ], 422);
        
    } catch (\Exception $e) {
        \Log::error('Server Error:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}
    
    public function destroy($id)
    {
        $result = WorkoutResult::findOrFail($id);
        $result->delete();
        
        return response()->noContent();
    }

    public function showByDate($date)
{
    $workouts = WorkoutResult::with('exercise')
        ->where('date', $date)
        ->orderBy('created_at', 'desc')
        ->get();
    
    return response()->json($workouts);
}
}