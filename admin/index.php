<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/helpers.php';

requireLogin();

$totalProyectos = $pdo->query('SELECT COUNT(*) FROM proyectos')->fetchColumn();
$totalArticulos = $pdo->query('SELECT COUNT(*) FROM articulos')->fetchColumn();
$totalPublicados = $pdo->query('SELECT COUNT(*) FROM articulos WHERE publicado = 1')->fetchColumn();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Cat Code CMS</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/bootstrap.min.css">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark px-4">
        <span class="navbar-brand fw-bold">Cat Code CMS</span>
        <div class="d-flex gap-3">
            <a href="<?= BASE_URL ?>/admin/proyectos/index.php" class="text-white text-decoration-none">Proyectos</a>
            <a href="<?= BASE_URL ?>/admin/blog/index.php" class="text-white text-decoration-none">Blog</a>
            <a href="<?= BASE_URL ?>/admin/logout.php" class="text-danger text-decoration-none">Cerrar sesión</a>
            <a href="<?= BASE_URL ?>/admin/contacto/index.php" class="text-white text-decoration-none">Mensajes</a>
        </div>
    </nav>

    <!-- Contenido -->
    <div class="container mt-5">
        <h4 class="mb-1">Bienvenido</h4>
        <p class="text-muted mb-4"><?= clean($_SESSION['usuario_email']) ?></p>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h1 class="display-4 fw-bold text-primary"><?= $totalProyectos ?></h1>
                        <p class="text-muted mb-0">Proyectos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h1 class="display-4 fw-bold text-secondary"><?= $totalArticulos ?></h1>
                        <p class="text-muted mb-0">Artículos totales</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h1 class="display-4 fw-bold text-success"><?= $totalPublicados ?></h1>
                        <p class="text-muted mb-0">Artículos publicados</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>

