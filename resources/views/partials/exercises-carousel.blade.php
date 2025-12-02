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

<style>
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
    
    .drag-hint {
        font-size: 14px;
        color: #6c757d;
        text-align: center;
        margin: 10px 0;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
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
    }
    
    @media (max-width: 576px) {
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
    }
    
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
    
    /* Touch device optimizations */
    @media (hover: none) and (pointer: coarse) {
        .exercise-card {
            cursor: pointer;
        }
        
        .exercise-card:hover {
            transform: none;
        }
    }
</style>