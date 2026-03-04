<!doctype html>
<html lang="es">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>VIP2CARS - Gestión de Vehículos</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
        <link href="../assets/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <i class="bi bi-car-front-fill me-2"></i>
            VIP2CARS
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Vehículos</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?action=new">Nuevo</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4">
    <section class="hero py-4 mb-4 rounded-3 text-white shadow-sm" style="background: linear-gradient(90deg,#0d6efd99,#6610f599);">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h2 class="h3 mb-0">Gestión de Vehículos</h2>
                <p class="mb-0 small opacity-75">Registro y administración de flota y contactos — VIP2CARS</p>
            </div>
            
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <?php if (!empty($flash)): ?>
                <div class="alert alert-info shadow-sm"><?= htmlspecialchars($flash) ?></div>
            <?php endif; ?>
            <div class="card shadow-sm">
                <div class="card-body">
                    <?= $content ?>
                </div>
            </div>
            <footer class="mt-3 text-center text-muted small">
                Sistema mínimo de ejemplo - VIP2CARS
            </footer>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/app.js"></script>
</body>
</html>
