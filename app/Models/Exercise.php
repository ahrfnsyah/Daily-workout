<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    protected $fillable = ['name', 'category'];
    
    protected $casts = [
        'category' => 'string'
    ];
    
    public function workoutResults(): HasMany
    {
        return $this->hasMany(WorkoutResult::class);
    }
}