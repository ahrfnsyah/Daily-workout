<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutResult extends Model
{
    protected $fillable = ['exercise_id', 'date', 'sets', 'reps'];
    
    protected $casts = [
        'date' => 'date'
    ];
    
    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }
}