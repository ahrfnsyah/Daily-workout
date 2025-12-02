<div class="workouts-by-date">
    <div class="modal-header">
        <h5 class="modal-title">
            <i class="far fa-calendar-alt me-2"></i>
            Workouts on {{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    
    <div class="modal-body">
        @if($workouts->isEmpty())
            <div class="text-center py-4">
                <i class="fas fa-dumbbell fa-3x text-muted mb-3"></i>
                <h5>No workouts recorded</h5>
                <p class="text-muted">Drag exercises to this date to add workouts</p>
            </div>
        @else
            <div class="workout-summary mb-4 p-3 bg-light rounded">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="display-6 fw-bold">{{ $workouts->count() }}</div>
                        <small class="text-muted">Exercises</small>
                    </div>
                    <div class="col-md-4">
                        <div class="display-6 fw-bold">{{ $workouts->sum('sets') }}</div>
                        <small class="text-muted">Total Sets</small>
                    </div>
                    <div class="col-md-4">
                        @php
                            $totalReps = 0;
                            foreach($workouts as $workout) {
                                $totalReps += $workout->sets * $workout->reps;
                            }
                        @endphp
                        <div class="display-6 fw-bold">{{ $totalReps }}</div>
                        <small class="text-muted">Total Reps</small>
                    </div>
                </div>
            </div>
            
            <div class="workout-list">
                @foreach($workouts as $workout)
                <div class="workout-item card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="card-title mb-1">
                                    <span class="badge bg-{{ $workout->exercise->category }} me-2">
                                        {{ $workout->exercise->category }}
                                    </span>
                                    {{ $workout->exercise->name }}
                                </h6>
                                <div class="text-muted small">
                                    <i class="far fa-clock me-1"></i>
                                    Logged at {{ $workout->created_at->format('H:i') }}
                                </div>
                            </div>
                            <button class="btn btn-sm btn-outline-danger delete-workout" 
                                    data-id="{{ $workout->id }}"
                                    title="Delete this workout">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="h4 mb-0">{{ $workout->sets }}</div>
                                    <small class="text-muted">Sets</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="h4 mb-0">{{ $workout->reps }}</div>
                                    <small class="text-muted">Reps per Set</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="h4 mb-0">{{ $workout->sets * $workout->reps }}</div>
                                    <small class="text-muted">Total Reps</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="progress mt-2" style="height: 8px;">
                            @php
                                $maxReps = $workouts->max(function($w) {
                                    return $w->sets * $w->reps;
                                });
                                $percentage = ($workout->sets * $workout->reps) / $maxReps * 100;
                            @endphp
                            <div class="progress-bar bg-{{ $workout->exercise->category }}" 
                                 role="progressbar" 
                                 style="width: {{ $percentage }}%">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        @if(!$workouts->isEmpty())
        <button type="button" class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print me-1"></i> Print Summary
        </button>
        @endif
    </div>
</div>

<style>
    .badge.bg-chest { background-color: #ff6b6b !important; }
    .badge.bg-back { background-color: #48dbfb !important; }
    .badge.bg-legs { background-color: #1dd1a1 !important; }
    .badge.bg-shoulders { background-color: #feca57 !important; color: #000; }
    .badge.bg-arms { background-color: #ff9ff3 !important; }
    .badge.bg-core { background-color: #54a0ff !important; }
    
    .progress-bar.bg-chest { background-color: #ff6b6b !important; }
    .progress-bar.bg-back { background-color: #48dbfb !important; }
    .progress-bar.bg-legs { background-color: #1dd1a1 !important; }
    .progress-bar.bg-shoulders { background-color: #feca57 !important; }
    .progress-bar.bg-arms { background-color: #ff9ff3 !important; }
    .progress-bar.bg-core { background-color: #54a0ff !important; }
    
    .workout-item:hover {
        transform: translateY(-2px);
        transition: transform 0.2s;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .workout-summary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .workout-summary .display-6 {
        color: white;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
</style>