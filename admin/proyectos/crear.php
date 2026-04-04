<?php
session_start();
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/upload.php';
requireLogin();

$error = '';
$exito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo      = clean($_POST['titulo'] ?? '');
    $descripcion = clean($_POST['descripcion'] ?? '');
    $orden       = (int)($_POST['orden'] ?? 0);
    $activo      = isset($_POST['activo']) ? 1 : 0;
    $imagen      = '';

    if (empty($titulo)) {
        $error = 'El título es obligatorio.';
    } else {
        // Manejo de imagen
if (!empty($_FILES['imagen']['name'])) {
    $resultado = subirImagen($_FILES['imagen'], 'proyectos', 'proj_');

    if (isset($resultado['error'])) {
        $error = $resultado['error'];
    } else {
        $imagen = $resultado['archivo'];
    }
}
        if (empty($error)) {
            $stmt = $pdo->prepare('INSERT INTO proyectos (titulo, descripcion, imagen, activo, orden) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$titulo, $descripcion, $imagen, $activo, $orden]);
            $exito = 'Proyecto creado correctamente.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Proyecto — Nativepress-cms</title>
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

    <div class="container mt-5" style="max-width: 700px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Nuevo Proyecto</h4>
            <a href="<?= BASE_URL ?>/admin/proyectos/index.php" class="btn btn-sm btn-secondary">← Volver</a>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($exito): ?>
            <div class="alert alert-success"><?= $exito ?></div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Título *</label>
                        <input type="text" name="titulo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Imagen</label>
                        <input type="file" name="imagen" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Orden</label>
                        <input type="number" name="orden" class="form-control" value="0">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="activo" class="form-check-input" id="activo" checked>
                        <label class="form-check-label" for="activo">Activo</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Guardar proyecto</button>
                </form>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
