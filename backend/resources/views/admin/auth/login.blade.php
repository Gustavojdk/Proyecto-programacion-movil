<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Panel administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h1 class="h4 mb-4 text-center">Iniciar sesión</h1>
                        <form>
                            <div class="mb-3">
                                <label class="form-label" for="email">Correo electrónico</label>
                                <input class="form-control" id="email" type="email" placeholder="admin@trufis.com">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="password">Contraseña</label>
                                <input class="form-control" id="password" type="password" placeholder="••••••••">
                            </div>
                            <a class="btn btn-primary w-100" href="{{ route('admin.dashboard') }}">Entrar al panel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
