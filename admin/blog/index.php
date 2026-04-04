<?php
session_start();
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';

requireLogin();

$articulos = $pdo->query('SELECT * FROM articulos ORDER BY created_at DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog — Nativepress-cms</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/bootstrap.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark px-4">
        <span class="navbar-brand fw-bold">Nativepress-cms</span>
        <div class="d-flex gap-3">
            <a href="<?= BASE_URL ?>/admin/index.php" class="text-white text-decoration-none">Dashboard</a>
            <a href="<?= BASE_URL ?>/admin/proyectos/index.php" class="text-white text-decoration-none">Proyectos</a>
            <a href="<?= BASE_URL ?>/admin/logout.php" class="text-danger text-decoration-none">Cerrar sesión</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Artículos</h4>
            <a href="<?= BASE_URL ?>/admin/blog/crear.php" class="btn btn-primary btn-sm">+ Nuevo artículo</a>
        </div>

        <?php if (empty($articulos)): ?>
            <div class="alert alert-info">No hay artículos todavía.</div>
        <?php else: ?>
            <table class="table table-bordered table-hover bg-white shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Título</th>
                        <th>Slug</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articulos as $a): ?>
                    <tr>
                        <td><?= clean($a['titulo']) ?></td>
                        <td><small class="text-muted"><?= $a['slug'] ?></small></td>
                        <td>
                            <?php if ($a['publicado']): ?>
                                <span class="badge bg-success">Publicado</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Borrador</span>
                            <?php endif; ?>
                        </td>
                        <td><small><?= date('d/m/Y', strtotime($a['created_at'])) ?></small></td>
                        <td>
                            <a href="<?= BASE_URL ?>/admin/blog/editar.php?id=<?= $a['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="<?= BASE_URL ?>/admin/blog/eliminar.php?id=<?= $a['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este artículo?')">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script src="<?= BASE_URL ?>/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>