<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - App Name</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">Exercise App</a>
        <div class="navbar-nav">
            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
            <a class="nav-link {{ request()->is('exercises*') ? 'active' : '' }}" href="/exercises">Exercises</a>
        </div>
    </div>
</nav>
    <main class="container py-4">
        @yield('content')
    </main>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            &copy; {{ date('Y') }} App Name
        </div>
    </footer>
</body>
</html>