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
        
        /* Responsive Mobile */
        @media (max-width: 768px) {
            .main-container {
                padding: 0 10px;
            }
        }
        
        @media (max-width: 576px) {
            body {
                padding: 15px 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="main-container">
        @yield('content')
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    
    @stack('scripts')
</body>
</html>