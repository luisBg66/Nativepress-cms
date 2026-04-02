<?php
session_start();
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';

requireLogin();

$proyectos = $pdo->query('SELECT * FROM proyectos ORDER BY orden ASC')->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Proyectos — Cat Code CMS</title>
      <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark px-4">
     <span class="navbar-brand fw-bold">Cat Code CMS</span>
     <div class="d-flex gap-3">
        <a href="<?= BASE_URL ?>/admin/index.php" class="text-white text-decoration-none">Dashboard</a>
        <a href="<?= BASE_URL ?>/admin/blog/index.php" class="text-white text-decoration-none">Blog</a>
        <a href="<?= BASE_URL ?>/admin/logout.php" class="text-danger text-decoration-none">Cerrar sesión</a>
     </div>
    </nav> 

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Proyectos</h4>
            <a href="<?= BASE_URL ?>/admin/proyectos/crear.php" class="btn btn-primary btn-sm">+ Nuevo proyecto</a>
        </div>

        <?php if (empty($proyectos)): ?>
            <div class="alert alert-info">No hay proyectos todavía.</div>
        <?php else: ?>
            <table class="table table-bordered table-hover bg-white shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Orden</th>
                        <th>Título</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($proyectos as $p): ?>
                    <tr>
                        <td><?= $p['orden'] ?></td>
                        <td><?= clean($p['titulo']) ?></td>
                        <td>
                            <?php if ($p['activo']): ?>
                                <span class="badge bg-success">Activo</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactivo</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>/admin/proyectos/editar.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="<?= BASE_URL ?>/admin/proyectos/eliminar.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este proyecto?')">Eliminar</a>
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
</body>
</html>



