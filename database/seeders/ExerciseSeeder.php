<?php

namespace Database\Seeders;

use App\Models\Exercise;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    public function run(): void
    {
        $exercises = [
            ['name' => 'Push Up', 'category' => 'chest'],
            ['name' => 'Pull Up', 'category' => 'back'],
            ['name' => 'Squat', 'category' => 'legs'],
            ['name' => 'Plank', 'category' => 'core'],
            ['name' => 'Bicep Curl', 'category' => 'arms'],
            ['name' => 'Shoulder Press', 'category' => 'shoulders'],
            ['name' => 'Deadlift', 'category' => 'back'],
            ['name' => 'Lunges', 'category' => 'legs'],
            ['name' => 'Bench Press', 'category' => 'chest'],
            ['name' => 'Russian Twist', 'category' => 'core'],
            ['name' => 'Rest day', 'category' => 'rest'],
        ];
        
        foreach ($exercises as $exercise) {
            Exercise::create($exercise);
        }
    }
}