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
    const date = info.event.startStr;
    const extendedProps = info.event.extendedProps || {};
    
    // TAMPILKAN MODAL VIEW (hanya view, tidak delete)
    showWorkoutsByDate(date, extendedProps.exercise_name);
},

// Tambah event untuk klik tanggal kosong
dateClick: function(info) {
    showWorkoutsByDate(info.dateStr);
},
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
    <td>${exercise.name}</td>
    <td><span class="badge bg-secondary d-inline-block text-center" style="width: 80px;">${exercise.category}</span></td>
    <td>
        <button class="btn btn-sm btn-warning me-1 edit-exercise" data-id="${exercise.id}" data-name="${exercise.name}" data-category="${exercise.category}">
            Edit
        </button>
        <button class="btn btn-sm btn-danger delete-exercise" data-id="${exercise.id}">
            Delete
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
        
function showWorkoutsByDate(date, exerciseName = null) {
    fetch(`/api/workout-results/date/${date}`)
    .then(response => response.json())
    .then(workouts => {
        const modal = new bootstrap.Modal(document.getElementById('viewWorkoutsModal'));
        const workoutsList = document.getElementById('workoutsList');
        const noWorkouts = document.getElementById('noWorkouts');
        
        // Set judul modal
        const formattedDate = new Date(date).toLocaleDateString('id-ID', {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
        document.getElementById('workoutsDateTitle').textContent = `📅 ${formattedDate}`;
        
        if (workouts.length > 0) {
            workoutsList.innerHTML = '';
            noWorkouts.style.display = 'none';
            
            workouts.forEach(workout => {
                const workoutEl = document.createElement('div');
                workoutEl.className = 'workout-item-simple';
                
                workoutEl.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0 fw-bold" style="font-size: 1rem;">${workout.exercise.name}</h6>
                        <span class="workout-category">${workout.exercise.category}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <div class="text-center" style="flex: 1;">
                            <div class="text-muted small">SETS</div>
                            <div class="fw-bold" style="font-size: 1.2rem;">${workout.sets}</div>
                        </div>
                        
                        <div class="text-center" style="flex: 1;">
                            <div class="text-muted small">REPS</div>
                            <div class="fw-bold" style="font-size: 1.2rem;">${workout.reps}</div>
                        </div>
                        
                        <div class="text-center" style="flex: 1;">
                            <div class="text-muted small">TOTAL</div>
                            <div class="fw-bold text-primary" style="font-size: 1.2rem;">${workout.sets * workout.reps}</div>
                        </div>
                    </div>
                    
                    <div class="text-end mt-2">
                        <small class="text-muted">${new Date(workout.created_at).toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})}</small>
                    </div>
                `;
                workoutsList.appendChild(workoutEl);
            });
            
            // Tambah summary total
            const totalWorkouts = workouts.length;
            const totalReps = workouts.reduce((sum, workout) => sum + (workout.sets * workout.reps), 0);
            
            const summaryEl = document.createElement('div');
            summaryEl.className = 'mt-3 pt-3 border-top';
            summaryEl.innerHTML = `
                <div class="d-flex justify-content-between">
                    <div class="fw-bold">Total Workouts:</div>
                    <div class="fw-bold">${totalWorkouts}</div>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="fw-bold">Total Reps:</div>
                    <div class="fw-bold text-primary">${totalReps}</div>
                </div>
            `;
            workoutsList.appendChild(summaryEl);
            
        } else {
            workoutsList.innerHTML = '';
            noWorkouts.style.display = 'block';
            noWorkouts.innerHTML = `
                <div class="text-center py-4">
                    <i class="fas fa-dumbbell fa-2x text-muted mb-3"></i>
                    <p class="text-muted mb-0">No workouts recorded</p>
                    <small class="text-muted">Drag exercise to this date</small>
                </div>
            `;
        }
        
        modal.show();
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error loading workouts', 'danger');
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