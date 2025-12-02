<!-- Modal: Add/Edit Exercise -->
<div class="modal fade" id="addExerciseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exerciseModalTitle">Add New Exercise</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="exerciseForm">
                    <input type="hidden" id="edit_exercise_id" name="id">
                    <div class="mb-3">
                        <label for="exercise_name" class="form-label">Exercise Name</label>
                        <input type="text" class="form-control" id="exercise_name_input" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="exercise_category" class="form-label">Category</label>
                        <select class="form-select" id="exercise_category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="chest">Chest</option>
                            <option value="back">Back</option>
                            <option value="legs">Legs</option>
                            <option value="shoulders">Shoulders</option>
                            <option value="arms">Arms</option>
                            <option value="core">Core</option>
                            <option value="rest">Rest</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveExerciseBtn">Save Exercise</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: View All Exercises -->
<div class="modal fade" id="viewExercisesModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">All Exercises</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="exercisesTable">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="exercisesTableBody">
                            <!-- Data akan diisi via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Log Workout -->
<div class="modal fade" id="workoutModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Log Workout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="workoutForm">
                    <input type="hidden" id="exercise_id" name="exercise_id">
                    <input type="hidden" id="workout_date" name="date">
                    
                    <div class="mb-3">
                        <label class="form-label">Exercise</label>
                        <input type="text" id="exercise_name" class="form-control" readonly>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sets" class="form-label">Sets</label>
                            <input type="number" class="form-control" id="sets" name="sets" min="1" max="20" value="3" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="reps" class="form-label">Reps per Set</label>
                            <input type="number" class="form-control" id="reps" name="reps" min="1" max="100" value="10" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveWorkout">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: View Workouts by Date -->
<div class="modal fade" id="viewWorkoutsModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h6 class="modal-title fw-bold mb-0" id="workoutsDateTitle"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div id="workoutsList" class="px-3">
                    <!-- Data akan diisi via JavaScript -->
                </div>
                <div id="noWorkouts" class="text-center py-4" style="display: none;">
                    <!-- Kosong -->
                </div>
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>

.workout-item-simple {
    border-bottom: 1px solid #e9ecef;
    padding: 12px 0;
}

.workout-item-simple:last-child {
    border-bottom: none;
}

.workout-category {
    font-size: 11px;
    padding: 2px 8px;
    border-radius: 10px;
    background: #e9ecef;
    color: #495057;
    text-transform: uppercase;
}
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.075);
    }
    
    @media (max-width: 768px) {
    #exercisesTable {
        font-size: 0.9rem;
    }
    
    #exercisesTable th,
    #exercisesTable td {
        padding: 8px 4px;
    }
    
    #exercisesTable .btn {
        padding: 2px 8px;
        font-size: 0.8rem;
    }
}
    /* Responsive */
    @media (max-width: 576px) {
        .modal-dialog {
            margin: 10px;
        }
        
        .modal-header h5 {
            font-size: 1.1rem;
        }
        
        .modal-body .form-label {
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .modal-body .form-control {
            padding: 8px;
            font-size: 0.9rem;
        }
        
        .modal-footer .btn {
            padding: 6px 12px;
            font-size: 0.9rem;
        }
        
        #exercisesTable {
        font-size: 0.85rem;
    }
    
    #exercisesTable .btn {
        display: inline-block;  /* Ubah dari block jadi inline-block */
        width: auto;            /* Hapus width 100% */
        margin-right: 5px;      /* Kasih margin kanan */
        margin-bottom: 0;       /* Hapus margin bawah */
    }
    
    #exercisesTable td:last-child {
        min-width: 150px;       /* Tambah sedikit lebar biar muat 2 tombol */
    }
    }
    
    @media (max-width: 400px) {
        .modal-dialog {
            margin: 5px;
        }
        
        /* Modal fullscreen on very small mobile */
        .modal-dialog {
            margin: 0;
            max-width: 100%;
            height: 100vh;
        }
        
        .modal-content {
            height: 100%;
            border-radius: 0;
            border: none;
        }
        
        .modal-body {
            max-height: calc(100vh - 120px);
            overflow-y: auto;
        }
    }
    
    /* Better form inputs for mobile (prevent zoom) */
    @media (max-width: 576px) {
        input, select, textarea {
            font-size: 16px !important;
        }
    }
    
    /* Touch device optimizations */
    @media (hover: none) and (pointer: coarse) {
        .btn {
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        input[type="number"],
        input[type="text"],
        select {
            min-height: 44px;
        }
    }
    
</style>