<?php
session_start();
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';

requireLogin();

// Marcar como leído si se recibe id
if (isset($_GET['leer'])) {
    $id = (int)$_GET['leer'];
    $pdo->prepare('UPDATE contacto SET leido = 1 WHERE id = ?')->execute([$id]);
    redirect('admin/contacto/index.php');
}

// Eliminar mensaje
if (isset($_GET['eliminar'])) {
    $id = (int)$_GET['eliminar'];
    $pdo->prepare('DELETE FROM contacto WHERE id = ?')->execute([$id]);
    redirect('admin/contacto/index.php');
}

$mensajes = $pdo->query('SELECT * FROM contacto ORDER BY created_at DESC')->fetchAll();
$noLeidos = $pdo->query('SELECT COUNT(*) FROM contacto WHERE leido = 0')->fetchColumn();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes — Cat Code CMS</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/bootstrap.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark px-4">
        <span class="navbar-brand fw-bold">Cat Code CMS</span>
        <div class="d-flex gap-3">
            <a href="<?= BASE_URL ?>/admin/index.php" class="text-white text-decoration-none">Dashboard</a>
            <a href="<?= BASE_URL ?>/admin/proyectos/index.php" class="text-white text-decoration-none">Proyectos</a>
            <a href="<?= BASE_URL ?>/admin/blog/index.php" class="text-white text-decoration-none">Blog</a>
            <a href="<?= BASE_URL ?>/admin/logout.php" class="text-danger text-decoration-none">Cerrar sesión</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                Mensajes de contacto
                <?php if ($noLeidos > 0): ?>
                    <span class="badge bg-danger ms-2"><?= $noLeidos ?> nuevos</span>
                <?php endif; ?>
            </h4>
        </div>

        <?php if (empty($mensajes)): ?>
            <div class="alert alert-info">No hay mensajes todavía.</div>
        <?php else: ?>
            <div class="row g-3">
                <?php foreach ($mensajes as $m): ?>
                <div class="col-12">
                    <div class="card shadow-sm <?= !$m['leido'] ? 'border-danger' : '' ?>">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold mb-1">
                                        <?= clean($m['nombre']) ?>
                                        <?php if (!$m['leido']): ?>
                                            <span class="badge bg-danger ms-1">Nuevo</span>
                                        <?php endif; ?>
                                    </h6>
                                    <small class="text-muted"><?= clean($m['email']) ?> — <?= date('d/m/Y H:i', strtotime($m['created_at'])) ?></small>
                                    <p class="mt-2 mb-0"><?= clean($m['mensaje']) ?></p>
                                </div>
                                <div class="d-flex gap-2 ms-3">
                                    <?php if (!$m['leido']): ?>
                                        <a href="?leer=<?= $m['id'] ?>" class="btn btn-sm btn-outline-success">Marcar leído</a>
                                    <?php endif; ?>
                                    <a href="?eliminar=<?= $m['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar mensaje?')">Eliminar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="<?= BASE_URL ?>/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>