<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\WorkoutResult;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $exercises = Exercise::all()->groupBy('category');
        return view('calendar', compact('exercises'));
    }
    
    // New method to get workouts by date
    public function getWorkoutsByDate(Request $request, $date)
    {
        $workouts = WorkoutResult::with('exercise')
            ->where('date', $date)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('partials.workouts-by-date', compact('workouts', 'date'));
    }
    
    // API method for modal
    public function getWorkoutsByDateApi(Request $request, $date)
    {
        $workouts = WorkoutResult::with('exercise')
            ->where('date', $date)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($workout) {
                return [
                    'id' => $workout->id,
                    'exercise_name' => $workout->exercise->name,
                    'exercise_category' => $workout->exercise->category,
                    'sets' => $workout->sets,
                    'reps' => $workout->reps,
                    'total_reps' => $workout->sets * $workout->reps,
                    'created_at' => $workout->created_at->format('H:i'),
                ];
            });
            
        return response()->json([
            'success' => true,
            'date' => $date,
            'workouts' => $workouts,
            'total_workouts' => $workouts->count(),
            'total_sets' => $workouts->sum('sets'),
            'total_reps' => $workouts->sum('total_reps'),
        ]);
    }
}