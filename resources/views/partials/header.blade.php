<!-- Header dengan Action Buttons -->
<div class="text-center mb-4">
    <h1 class="page-title">🏋️ Daily Workout Tracker</h1>
    <p class="text-muted">Drag exercises to calendar dates to log your workouts</p>
    
    <div class="action-buttons">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addExerciseModal">
            <i class="fas fa-plus-circle me-1"></i> Add New Exercise
        </button>
        <button type="button" class="btn btn-info" id="viewExercisesBtn">
            <i class="fas fa-list me-1"></i> View All Exercises
        </button>
    </div>
</div>

<style>
    .page-title {
        color: #2c3e50;
        margin-bottom: 10px;
        font-size: 1.8rem;
    }
    
    .action-buttons {
        margin-bottom: 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.5rem;
        }
        
        .action-buttons {
            flex-direction: column;
            align-items: stretch;
        }
        
        .action-buttons .btn {
            width: 100%;
            margin-bottom: 5px;
        }
    }
    
    @media (max-width: 576px) {
        .page-title {
            font-size: 1.3rem;
            margin-bottom: 8px;
        }
        
        .page-title + p {
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
    }
</style>