<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->integer('sets');
            $table->integer('reps');
            $table->timestamps();
            
            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_results');
    }
};