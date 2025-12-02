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

<style>
    .calendar-wrapper {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        margin-bottom: 20px;
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
    
    .drag-over-day {
        background-color: rgba(0, 123, 255, 0.1) !important;
        border: 2px dashed #007bff !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
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
    
    @media (max-width: 576px) {
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
    }
    
    @media (max-width: 400px) {
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
    }
    
    /* Touch device optimizations */
    @media (hover: none) and (pointer: coarse) {
        .fc-event {
            min-height: 35px !important;
        }
    }

    /* Style for workout items */
.workout-item {
    border-left: 4px solid;
    transition: all 0.2s;
}

.workout-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Category colors for workout items */
.workout-item.chest { border-left-color: #ff6b6b; }
.workout-item.back { border-left-color: #48dbfb; }
.workout-item.legs { border-left-color: #1dd1a1; }
.workout-item.shoulders { border-left-color: #feca57; }
.workout-item.arms { border-left-color: #ff9ff3; }
.workout-item.core { border-left-color: #54a0ff; }

/* Make calendar dates clickable */
.fc-daygrid-day {
    cursor: pointer;
}

.fc-daygrid-day:hover {
    background-color: rgba(0, 123, 255, 0.05);
}

/* Workout summary styles */
.workout-summary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
}

.workout-summary .display-6 {
    color: white;
    text-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

/* Responsive for workout modal */
@media (max-width: 768px) {
    .workout-summary .display-6 {
        font-size: 2rem;
    }
    
    .workout-item .h4 {
        font-size: 1.5rem;
    }
}
</style>