<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\WorkoutResultController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CalendarController::class, 'index'])->name('calendar.index');

// View workouts by date
Route::get('/workouts/{date}', [CalendarController::class, 'getWorkoutsByDate'])
    ->where('date', '[0-9]{4}-[0-9]{2}-[0-9]{2}');
    
// API routes
Route::prefix('api')->group(function () {
    // Workout Results
    Route::get('/workout-results', [WorkoutResultController::class, 'index']);
    Route::post('/workout-results', [WorkoutResultController::class, 'store']);
    Route::get('/workout-results/date/{date}', [WorkoutResultController::class, 'showByDate']);
    Route::delete('/workout-results/{id}', [WorkoutResultController::class, 'destroy']);
    
    // Get workouts by date
    Route::get('/workouts/{date}', [CalendarController::class, 'getWorkoutsByDateApi'])
        ->where('date', '[0-9]{4}-[0-9]{2}-[0-9]{2}');
    
    // Exercises CRUD
    Route::get('/exercises', [ExerciseController::class, 'index']);
    Route::post('/exercises', [ExerciseController::class, 'store']);
    Route::put('/exercises/{id}', [ExerciseController::class, 'update']);
    Route::delete('/exercises/{id}', [ExerciseController::class, 'destroy']);
});