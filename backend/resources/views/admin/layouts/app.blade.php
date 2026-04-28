<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel administrativo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="d-flex min-vh-100">
        <aside class="bg-dark text-white p-3" style="width: 250px;">
            <h5 class="mb-4">Trufis Admin</h5>
            <nav class="nav flex-column">
                <a class="nav-link text-white p-0 mb-2" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="nav-link text-white-50 p-0 mb-2" href="#">Usuarios</a>
                <a class="nav-link text-white-50 p-0" href="#">Reportes</a>
            </nav>
        </aside>

        <main class="flex-grow-1">
            <header class="bg-white border-bottom px-4 py-3">
                <h1 class="h4 m-0">@yield('page_title', 'Dashboard')</h1>
            </header>
            <section class="p-4">
                @yield('content')
            </section>
        </main>
    </div>
</body>
</html>
