<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daily Workout Tracker</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
    
    <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .exercise-card {
            background: white;
            border-radius: 10px;
            padding: 12px 15px;
            margin: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            cursor: grab;
            transition: all 0.2s;
            width: 160px;
            flex-shrink: 0;
            border-left: 4px solid;
        }
        
        .exercise-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .exercise-card:active {
            cursor: grabbing;
        }
        
        .exercise-card.chest { border-color: #ff6b6b; }
        .exercise-card.back { border-color: #48dbfb; }
        .exercise-card.legs { border-color: #1dd1a1; }
        .exercise-card.shoulders { border-color: #feca57; }
        .exercise-card.arms { border-color: #ff9ff3; }
        .exercise-card.core { border-color: #54a0ff; }
        
        .category-badge {
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 10px;
            background: #e9ecef;
            color: #495057;
            text-transform: uppercase;
        }
        
        .carousel-row {
            background: white;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            overflow: hidden;
            position: relative;
        }
        
        /* Row 1 - Left to Right */
        .carousel-track.row-1 {
            display: flex;
            animation: scrollLeftToRight 8s linear infinite;
        }
        
        /* Row 2 - Right to Left */
        .carousel-track.row-2 {
            display: flex;
            animation: scrollRightToLeft 20s linear infinite;
        }
        
        .carousel-row:hover .carousel-track {
            animation-play-state: paused;
        }
        
        /* Animation for Row 1: Left to Right */
        @keyframes scrollLeftToRight {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        /* Animation for Row 2: Right to Left */
        @keyframes scrollRightToLeft {
            0% { transform: translateX(-50%); }
            100% { transform: translateX(0); }
        }
        
        /* Calendar Event Styles */
        .fc-event {
            cursor: pointer;
            border-radius: 6px !important;
            padding: 4px 6px !important;
            margin: 2px 1px !important;
            font-size: 11px !important;
            min-height: 40px !important;
            display: flex !important;
            align-items: center !important;
        }
        
        .fc-event:hover {
            opacity: 0.9;
            transform: scale(1.02);
            transition: all 0.2s;
        }
        
        .custom-event {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        /* Make calendar cells larger to fit content */
        .fc-daygrid-day-frame {
            min-height: 80px !important;
        }
        
        .fc-daygrid-day-events {
            min-height: 50px !important;
        }
        
        /* Event colors based on category */
        .event-chest { background-color: #ff6b6b !important; border-color: #ff6b6b !important; }
        .event-back { background-color: #48dbfb !important; border-color: #48dbfb !important; }
        .event-legs { background-color: #1dd1a1 !important; border-color: #1dd1a1 !important; }
        .event-shoulders { background-color: #feca57 !important; border-color: #feca57 !important; }
        .event-arms { background-color: #ff9ff3 !important; border-color: #ff9ff3 !important; }
        .event-core { background-color: #54a0ff !important; border-color: #54a0ff !important; }
        
        .calendar-wrapper {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        
        .drag-hint {
            font-size: 14px;
            color: #6c757d;
            text-align: center;
            margin: 10px 0;
        }
        
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
        
        .drag-over-day {
            background-color: rgba(0, 123, 255, 0.1) !important;
            border: 2px dashed #007bff !important;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.075);
        }
        
        /* ==================== RESPONSIVE MOBILE ==================== */
        
        /* Tablet (768px ke bawah) */
        @media (max-width: 768px) {
            .main-container {
                padding: 0 10px;
            }
            
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
            
            .exercise-card {
                width: 140px;
                padding: 10px 12px;
                margin: 6px;
            }
            
            .exercise-card h6 {
                font-size: 0.9rem;
            }
            
            .carousel-row {
                padding: 12px;
                margin-bottom: 15px;
            }
            
            .calendar-wrapper {
                padding: 15px;
            }
            
            .calendar-wrapper h4 {
                font-size: 1.3rem;
            }
            
            .btn-group {
                flex-wrap: wrap;
            }
            
            .btn-group .btn-sm {
                padding: 4px 8px;
                font-size: 0.85rem;
            }
            
            /* FullCalendar responsive */
            .fc .fc-toolbar {
                flex-direction: column;
                gap: 10px;
            }
            
            .fc .fc-toolbar-title {
                font-size: 1.3rem;
                margin-bottom: 10px;
            }
            
            .fc .fc-button {
                padding: 5px 10px;
                font-size: 0.85rem;
            }
            
            .fc .fc-daygrid-day-frame {
                min-height: 70px !important;
            }
            
            .fc-event {
                font-size: 10px !important;
                padding: 3px 4px !important;
                min-height: 35px !important;
            }
        }
        
        /* Mobile kecil (576px ke bawah) */
        @media (max-width: 576px) {
            body {
                padding: 15px 0;
            }
            
            .page-title {
                font-size: 1.3rem;
                margin-bottom: 8px;
            }
            
            .page-title + p {
                font-size: 0.9rem;
                margin-bottom: 15px;
            }
            
            .exercise-card {
                width: 130px;
                padding: 8px 10px;
                margin: 5px;
            }
            
            .exercise-card h6 {
                font-size: 0.85rem;
                margin-bottom: 2px;
            }
            
            .category-badge {
                font-size: 9px;
                padding: 1px 6px;
            }
            
            .drag-hint {
                font-size: 12px;
                margin: 8px 0;
            }
            
            .calendar-wrapper h4 {
                font-size: 1.1rem;
                margin-bottom: 10px;
            }
            
            .btn-group .btn-sm {
                padding: 3px 6px;
                font-size: 0.8rem;
            }
            
            /* FullCalendar mobile optimization */
            .fc .fc-toolbar-title {
                font-size: 1.1rem;
            }
            
            .fc .fc-button {
                padding: 4px 8px;
                font-size: 0.8rem;
            }
            
            .fc .fc-daygrid-day-frame {
                min-height: 60px !important;
            }
            
            .fc-event {
                font-size: 9px !important;
                padding: 2px 3px !important;
                min-height: 30px !important;
            }
            
            .fc .fc-col-header-cell {
                font-size: 0.75rem;
                padding: 4px 2px !important;
            }
            
            .fc .fc-daygrid-day-top {
                font-size: 0.75rem;
                padding: 2px !important;
            }
            
            /* Modal mobile */
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
            
            /* Table responsive */
            #exercisesTable {
                font-size: 0.85rem;
            }
            
            #exercisesTable th,
            #exercisesTable td {
                padding: 6px 4px;
            }
            
            #exercisesTable .btn-sm {
                padding: 3px 6px;
                font-size: 0.8rem;
            }
        }
        
        /* Mobile sangat kecil (400px ke bawah) */
        @media (max-width: 400px) {
            .exercise-card {
                width: 120px;
                padding: 6px 8px;
                margin: 4px;
            }
            
            .exercise-card h6 {
                font-size: 0.8rem;
            }
            
            .carousel-row {
                padding: 10px;
            }
            
            .carousel-track.row-1,
            .carousel-track.row-2 {
                animation-duration: 6s !important;
            }
            
            .fc .fc-toolbar-title {
                font-size: 1rem;
            }
            
            .fc .fc-col-header-cell {
                font-size: 0.7rem;
                padding: 3px 1px !important;
            }
            
            .fc .fc-daygrid-day-top {
                font-size: 0.7rem;
            }
            
            .modal-dialog {
                margin: 5px;
            }
        }
        
        /* Touch device optimizations */
        @media (hover: none) and (pointer: coarse) {
            .exercise-card {
                cursor: pointer;
            }
            
            .exercise-card:hover {
                transform: none;
            }
            
            .fc-event {
                min-height: 35px !important;
            }
            
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
        
        /* Better form inputs for mobile (prevent zoom) */
        @media (max-width: 576px) {
            input, select, textarea {
                font-size: 16px !important;
            }
        }
        
        /* Modal fullscreen on very small mobile */
        @media (max-width: 400px) {
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
        
        /* Hide animation on mobile and enable manual scroll */
        @media (max-width: 768px) {
            .carousel-row {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
            }
            
            .carousel-row::-webkit-scrollbar {
                display: none;
            }
            
            .carousel-track {
                animation: none !important;
                width: max-content;
            }
        }
        
        /* Landscape orientation */
        @media (max-height: 600px) and (orientation: landscape) {
            .carousel-row {
                margin-bottom: 10px;
                padding: 10px;
            }
            
            .exercise-card {
                width: 140px;
            }
            
            .calendar-wrapper {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
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
        
        <!-- Exercises Section - 2 Rows -->
        <div class="mb-4">
            <!-- Row 1: Left to Right -->
            <div class="carousel-row mb-3">
                <div class="carousel-track row-1" id="carousel-row-1">
                    @foreach($exercises as $category => $items)
                        @foreach($items as $exercise)
                        <div class="exercise-card {{ $category }}" 
                             draggable="true"
                             data-exercise-id="{{ $exercise->id }}"
                             data-exercise-name="{{ $exercise->name }}"
                             data-category="{{ $category }}">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="category-badge">{{ $category }}</span>
                                <i class="fas fa-arrows-alt text-muted" style="font-size: 12px;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold">{{ $exercise->name }}</h6>
                        </div>
                        @endforeach
                    @endforeach
                    
                    <!-- Duplicate for seamless loop -->
                    @foreach($exercises as $category => $items)
                        @foreach($items as $exercise)
                        <div class="exercise-card {{ $category }}" 
                             draggable="true"
                             data-exercise-id="{{ $exercise->id }}"
                             data-exercise-name="{{ $exercise->name }}"
                             data-category="{{ $category }}">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="category-badge">{{ $category }}</span>
                                <i class="fas fa-arrows-alt text-muted" style="font-size: 12px;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold">{{ $exercise->name }}</h6>
                        </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
            
            <!-- Row 2: Right to Left (REVERSED ORDER) -->
            <div class="carousel-row">
                <div class="carousel-track row-2" id="carousel-row-2">
                    @php
                        // Get all exercises as array
                        $allExercises = [];
                        foreach($exercises as $category => $items) {
                            foreach($items as $exercise) {
                                $allExercises[] = [
                                    'category' => $category,
                                    'exercise' => $exercise
                                ];
                            }
                        }
                        // Reverse the array for bottom row
                        $reversedExercises = array_reverse($allExercises);
                    @endphp
                    
                    @foreach($reversedExercises as $item)
                    <div class="exercise-card {{ $item['category'] }}" 
                         draggable="true"
                         data-exercise-id="{{ $item['exercise']->id }}"
                         data-exercise-name="{{ $item['exercise']->name }}"
                         data-category="{{ $item['category'] }}">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <span class="category-badge">{{ $item['category'] }}</span>
                            <i class="fas fa-arrows-alt text-muted" style="font-size: 12px;"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">{{ $item['exercise']->name }}</h6>
                    </div>
                    @endforeach
                    
                    <!-- Original order for seamless loop -->
                    @foreach($allExercises as $item)
                    <div class="exercise-card {{ $item['category'] }}" 
                         draggable="true"
                         data-exercise-id="{{ $item['exercise']->id }}"
                         data-exercise-name="{{ $item['exercise']->name }}"
                         data-category="{{ $item['category'] }}">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <span class="category-badge">{{ $item['category'] }}</span>
                            <i class="fas fa-arrows-alt text-muted" style="font-size: 12px;"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">{{ $item['exercise']->name }}</h6>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <p class="drag-hint">← Scroll or drag exercises to calendar →</p>
        </div>
        
        <!-- Calendar -->
        <div class="calendar-wrapper">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">📅 Workout Calendar</h4>
                <div class="btn-group">
                    <button id="prevBtn" class="btn btn-outline-secondary btn-sm">Prev</button>
                    <button id="todayBtn" class="btn btn-primary btn-sm">Today</button>
                    <button id="nextBtn" class="btn btn-outline-secondary btn-sm">Next</button>
                </div>
            </div>
            
            <div id="calendar"></div>
        </div>
    </div>
    
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
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Created At</th>
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
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            
            // Store data for drag
            let draggedExercise = null;
            
            // Setup drag events for exercise cards
            document.querySelectorAll('.exercise-card').forEach(card => {
                card.addEventListener('dragstart', function(e) {
                    draggedExercise = {
                        id: this.dataset.exerciseId,
                        name: this.dataset.exerciseName,
                        category: this.dataset.category
                    };
                    
                    e.dataTransfer.setData('text/plain', JSON.stringify(draggedExercise));
                    e.dataTransfer.effectAllowed = 'copy';
                    this.style.opacity = '0.5';
                });
                
                card.addEventListener('dragend', function() {
                    this.style.opacity = '1';
                    draggedExercise = null;
                });
            });
            
            // Calendar Initialization
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek'
                },
                editable: true,
                droppable: true,
                events: '/api/workout-results',
                
                eventContent: function(arg) {
                    const event = arg.event;
                    const extendedProps = event.extendedProps || {};
                    
                    const eventEl = document.createElement('div');
                    eventEl.className = 'custom-event';
                    eventEl.style.cssText = `
                        padding: 2px 4px;
                        border-radius: 3px;
                        font-size: 11px;
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                    `;
                    
                    if (extendedProps.exercise_name && extendedProps.sets && extendedProps.reps) {
                        eventEl.innerHTML = `
                            <div class="fw-bold">${extendedProps.exercise_name}</div>
                            <div>${extendedProps.sets} × ${extendedProps.reps}</div>
                        `;
                    } else {
                        eventEl.innerHTML = `<div>${event.title}</div>`;
                    }
                    
                    return { domNodes: [eventEl] };
                },
                
                eventMouseEnter: function(info) {
                    const extendedProps = info.event.extendedProps || {};
                    if (extendedProps.exercise_name) {
                        const tooltip = `
                            <div class="event-tooltip p-2" style="
                                background: white;
                                border-radius: 8px;
                                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                                max-width: 200px;
                                z-index: 9999;
                            ">
                                <div class="fw-bold">${extendedProps.exercise_name}</div>
                                <div>Sets: ${extendedProps.sets || 'N/A'}</div>
                                <div>Reps: ${extendedProps.reps || 'N/A'}</div>
                                <div>Category: ${extendedProps.category || 'N/A'}</div>
                                <div class="text-muted mt-1">Click to delete</div>
                            </div>
                        `;
                        
                        const tooltipEl = document.createElement('div');
                        tooltipEl.innerHTML = tooltip;
                        tooltipEl.style.position = 'absolute';
                        tooltipEl.style.top = (info.jsEvent.pageY + 10) + 'px';
                        tooltipEl.style.left = (info.jsEvent.pageX + 10) + 'px';
                        tooltipEl.className = 'event-tooltip-container';
                        
                        document.body.appendChild(tooltipEl);
                        info.el.tooltip = tooltipEl;
                    }
                },
                
                eventMouseLeave: function(info) {
                    if (info.el.tooltip) {
                        info.el.tooltip.remove();
                    }
                },
                
                drop: function(info) {
                    handleCalendarDrop(info.date, draggedExercise || 
                        JSON.parse(info.draggedEl.dataset.exerciseData || '{}'));
                },
                
                eventClick: function(info) {
                    const extendedProps = info.event.extendedProps || {};
                    const deleteMsg = `
                        Delete workout?
                        <br><br>
                        <strong>${extendedProps.exercise_name || info.event.title}</strong><br>
                        ${extendedProps.sets || '?'} sets × ${extendedProps.reps || '?'} reps<br>
                    `;
                    
                    if (confirm(deleteMsg)) {
                        deleteWorkout(info.event.id);
                    }
                }
            });
            
            calendar.render();
            
            // Make calendar a drop zone
            calendarEl.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'copy';
                this.style.backgroundColor = 'rgba(0, 123, 255, 0.05)';
            });
            
            calendarEl.addEventListener('dragleave', function(e) {
                this.style.backgroundColor = '';
            });
            
            // Handle exercise drop to calendar
            function handleCalendarDrop(dropDate, exerciseData) {
                if (!exerciseData || !exerciseData.id) return;
                
                document.getElementById('exercise_id').value = exerciseData.id;
                document.getElementById('exercise_name').value = exerciseData.name;
                document.getElementById('workout_date').value = dropDate.toISOString().split('T')[0];
                
                const modal = new bootstrap.Modal(document.getElementById('workoutModal'));
                modal.show();
            }
            
            // Navigation
            document.getElementById('prevBtn').addEventListener('click', () => calendar.prev());
            document.getElementById('nextBtn').addEventListener('click', () => calendar.next());
            document.getElementById('todayBtn').addEventListener('click', () => calendar.today());
            
            // Save workout
            document.getElementById('saveWorkout').addEventListener('click', function() {
                const formData = new FormData(document.getElementById('workoutForm'));
                const workoutData = Object.fromEntries(formData);
                
                workoutData.sets = parseInt(workoutData.sets);
                workoutData.reps = parseInt(workoutData.reps);
                workoutData.exercise_id = parseInt(workoutData.exercise_id);
                
                fetch('/api/workout-results', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(workoutData)
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    bootstrap.Modal.getInstance(document.getElementById('workoutModal')).hide();
                    calendar.refetchEvents();
                    showAlert('Workout saved successfully!', 'success');
                    document.getElementById('sets').value = '3';
                    document.getElementById('reps').value = '10';
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error: ' + error.message, 'danger');
                });
            });
            
            // View All Exercises Button
            document.getElementById('viewExercisesBtn').addEventListener('click', function() {
                loadExercisesTable();
                const modal = new bootstrap.Modal(document.getElementById('viewExercisesModal'));
                modal.show();
            });
            
            // Load exercises for table
            function loadExercisesTable() {
                fetch('/api/exercises')
                .then(response => response.json())
                .then(exercises => {
                    const tbody = document.getElementById('exercisesTableBody');
                    tbody.innerHTML = '';
                    
                    exercises.forEach(exercise => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${exercise.id}</td>
                            <td>${exercise.name}</td>
                            <td><span class="badge bg-secondary">${exercise.category}</span></td>
                            <td>${new Date(exercise.created_at).toLocaleDateString()}</td>
                            <td>
                                <button class="btn btn-sm btn-warning me-1 edit-exercise" data-id="${exercise.id}" data-name="${exercise.name}" data-category="${exercise.category}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-exercise" data-id="${exercise.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                    
                    // Add event listeners to edit buttons
                    document.querySelectorAll('.edit-exercise').forEach(btn => {
                        btn.addEventListener('click', function() {
                            editExercise(
                                this.dataset.id,
                                this.dataset.name,
                                this.dataset.category
                            );
                        });
                    });
                    
                    // Add event listeners to delete buttons
                    document.querySelectorAll('.delete-exercise').forEach(btn => {
                        btn.addEventListener('click', function() {
                            deleteExercise(this.dataset.id);
                        });
                    });
                })
                .catch(error => {
                    console.error('Error loading exercises:', error);
                    showAlert('Error loading exercises', 'danger');
                });
            }
            
            // Edit Exercise
            function editExercise(id, name, category) {
                document.getElementById('edit_exercise_id').value = id;
                document.getElementById('exercise_name_input').value = name;
                document.getElementById('exercise_category').value = category;
                document.getElementById('exerciseModalTitle').textContent = 'Edit Exercise';
                
                // Close view modal
                bootstrap.Modal.getInstance(document.getElementById('viewExercisesModal')).hide();
                
                // Open edit modal
                const modal = new bootstrap.Modal(document.getElementById('addExerciseModal'));
                modal.show();
            }
            
            // Delete Exercise
            function deleteExercise(id) {
                if (!confirm('Are you sure you want to delete this exercise? All related workout results will also be deleted.')) {
                    return;
                }
                
                fetch(`/api/exercises/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => {
                    if (response.ok) {
                        loadExercisesTable(); // Refresh table
                        refreshExerciseCards(); // Refresh carousel
                        showAlert('Exercise deleted successfully', 'success');
                    } else {
                        throw new Error('Delete failed');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error deleting exercise', 'danger');
                });
            }
            
            // Save Exercise (Add/Edit)
            document.getElementById('saveExerciseBtn').addEventListener('click', function() {
                const exerciseId = document.getElementById('edit_exercise_id').value;
                const method = exerciseId ? 'PUT' : 'POST';
                const url = exerciseId ? `/api/exercises/${exerciseId}` : '/api/exercises';
                
                const exerciseData = {
                    name: document.getElementById('exercise_name_input').value,
                    category: document.getElementById('exercise_category').value
                };
                
                fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(exerciseData)
                })
                .then(response => response.json())
                .then(data => {
                    bootstrap.Modal.getInstance(document.getElementById('addExerciseModal')).hide();
                    resetExerciseForm();
                    refreshExerciseCards();
                    
                    if (method === 'POST') {
                        showAlert('Exercise added successfully!', 'success');
                    } else {
                        showAlert('Exercise updated successfully!', 'success');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error saving exercise', 'danger');
                });
            });
            
            // Reset exercise form
            function resetExerciseForm() {
                document.getElementById('exerciseForm').reset();
                document.getElementById('edit_exercise_id').value = '';
                document.getElementById('exerciseModalTitle').textContent = 'Add New Exercise';
            }
            
            // Refresh exercise cards in carousel
            function refreshExerciseCards() {
                fetch('/api/exercises')
                .then(response => response.json())
                .then(exercises => {
                    // Group by category
                    const grouped = {};
                    exercises.forEach(exercise => {
                        if (!grouped[exercise.category]) {
                            grouped[exercise.category] = [];
                        }
                        grouped[exercise.category].push(exercise);
                    });
                    
                    // Update carousel rows
                    updateCarouselRows(grouped);
                });
            }
            
            // Update carousel rows with new data
            function updateCarouselRows(exercisesByCategory) {
                const carouselRows = [
                    document.getElementById('carousel-row-1'),
                    document.getElementById('carousel-row-2')
                ];
                
                carouselRows.forEach(row => {
                    row.innerHTML = '';
                    
                    // Add all exercises twice for seamless loop
                    for (let i = 0; i < 2; i++) {
                        for (const [category, exercises] of Object.entries(exercisesByCategory)) {
                            exercises.forEach(exercise => {
                                const card = document.createElement('div');
                                card.className = `exercise-card ${category}`;
                                card.draggable = true;
                                card.dataset.exerciseId = exercise.id;
                                card.dataset.exerciseName = exercise.name;
                                card.dataset.category = category;
                                
                                card.innerHTML = `
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <span class="category-badge">${category}</span>
                                        <i class="fas fa-arrows-alt text-muted" style="font-size: 12px;"></i>
                                    </div>
                                    <h6 class="mb-0 fw-bold">${exercise.name}</h6>
                                `;
                                
                                // Add drag events
                                card.addEventListener('dragstart', function(e) {
                                    draggedExercise = {
                                        id: this.dataset.exerciseId,
                                        name: this.dataset.exerciseName,
                                        category: this.dataset.category
                                    };
                                    e.dataTransfer.setData('text/plain', JSON.stringify(draggedExercise));
                                    e.dataTransfer.effectAllowed = 'copy';
                                    this.style.opacity = '0.5';
                                });
                                
                                card.addEventListener('dragend', function() {
                                    this.style.opacity = '1';
                                    draggedExercise = null;
                                });
                                
                                card.dataset.exerciseData = JSON.stringify({
                                    id: exercise.id,
                                    name: exercise.name,
                                    category: category
                                });
                                
                                row.appendChild(card);
                            });
                        }
                    }
                });
            }
            
            // Helper functions
            function deleteWorkout(id) {
                if (!confirm('Are you sure you want to delete this workout?')) return;
                
                fetch(`/api/workout-results/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                })
                .then(response => {
                    if (response.ok) {
                        calendar.refetchEvents();
                        showAlert('Workout deleted', 'success');
                    } else throw new Error('Delete failed');
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error deleting workout', 'danger');
                });
            }
            
            function showAlert(message, type) {
                const alert = document.createElement('div');
                alert.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
                alert.style.top = '20px';
                alert.style.right = '20px';
                alert.style.zIndex = '9999';
                alert.style.minWidth = '300px';
                alert.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(alert);
                setTimeout(() => alert.remove(), 3000);
            }
            
            // Setup exercise data for all cards
            document.querySelectorAll('.exercise-card').forEach(card => {
                card.dataset.exerciseData = JSON.stringify({
                    id: card.dataset.exerciseId,
                    name: card.dataset.exerciseName,
                    category: card.dataset.category
                });
            });
            
            // Direct drop handling for calendar days
            document.querySelectorAll('#calendar .fc-daygrid-day').forEach(day => {
                day.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.classList.add('drag-over-day');
                });
                
                day.addEventListener('dragleave', function() {
                    this.classList.remove('drag-over-day');
                });
                
                day.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.classList.remove('drag-over-day');
                    
                    if (draggedExercise) {
                        const dateStr = this.getAttribute('data-date');
                        if (dateStr) {
                            handleCalendarDrop(new Date(dateStr), draggedExercise);
                        }
                    }
                });
            });
            
            // Reset form when modal closes
            document.getElementById('addExerciseModal').addEventListener('hidden.bs.modal', function() {
                resetExerciseForm();
            });
        });
    </script>
</body>
</html>