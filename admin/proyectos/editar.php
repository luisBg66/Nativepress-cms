<?php
session_start();
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';

requireLogin();

$id = (int)($_GET['id'] ?? 0);

if (!$id) {
    redirect('admin/proyectos/index.php');
}

$stmt = $pdo->prepare('SELECT * FROM proyectos WHERE id = ?');
$stmt->execute([$id]);
$proyecto = $stmt->fetch();

if (!$proyecto) {
    redirect('admin/proyectos/index.php');
}

$error = '';
$exito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo      = clean($_POST['titulo'] ?? '');
    $descripcion = clean($_POST['descripcion'] ?? '');
    $orden       = (int)($_POST['orden'] ?? 0);
    $activo      = isset($_POST['activo']) ? 1 : 0;
    $imagen      = $proyecto['imagen'];

    if (empty($titulo)) {
        $error = 'El título es obligatorio.';
    } else {
        // Manejo de imagen nueva
        if (!empty($_FILES['imagen']['name'])) {
            $ext        = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
            $permitidos = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($ext, $permitidos)) {
                $error = 'Formato de imagen no permitido.';
            } elseif ($_FILES['imagen']['size'] > MAX_FILE_SIZE) {
                $error = 'La imagen supera el tamaño máximo de 2MB.';
            } else {
                $nombreArchivo = uniqid('proj_') . '.' . $ext;
                $destino       = UPLOAD_PATH . '/proyectos/' . $nombreArchivo;

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
                    // Eliminar imagen anterior
                    if ($proyecto['imagen'] && file_exists(UPLOAD_PATH . '/proyectos/' . $proyecto['imagen'])) {
                        unlink(UPLOAD_PATH . '/proyectos/' . $proyecto['imagen']);
                    }
                    $imagen = $nombreArchivo;
                } else {
                    $error = 'Error al subir la imagen.';
                }
            }
        }

        if (empty($error)) {
            $stmt = $pdo->prepare('UPDATE proyectos SET titulo = ?, descripcion = ?, imagen = ?, activo = ?, orden = ? WHERE id = ?');
            $stmt->execute([$titulo, $descripcion, $imagen, $activo, $orden, $id]);
            $exito = 'Proyecto actualizado correctamente.';

            // Recargar datos actualizados
            $stmt = $pdo->prepare('SELECT * FROM proyectos WHERE id = ?');
            $stmt->execute([$id]);
            $proyecto = $stmt->fetch();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proyecto — Cat Code CMS</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/bootstrap.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark px-4">
        <span class="navbar-brand fw-bold">Cat Code CMS</span>
        <div class="d-flex gap-3">
            <a href="<?= BASE_URL ?>/admin/index.php" class="text-white text-decoration-none">Dashboard</a>
            <a href="<?= BASE_URL ?>/admin/proyectos/index.php" class="text-white text-decoration-none">Proyectos</a>
            <a href="<?= BASE_URL ?>/admin/logout.php" class="text-danger text-decoration-none">Cerrar sesión</a>
        </div>
    </nav>

    <div class="container mt-5" style="max-width: 700px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Editar Proyecto</h4>
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
                        <input type="text" name="titulo" class="form-control" value="<?= clean($proyecto['titulo']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="4"><?= clean($proyecto['descripcion']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Imagen actual</label><br>
                        <?php if ($proyecto['imagen']): ?>
                            <img src="<?= BASE_URL ?>/uploads/proyectos/<?= $proyecto['imagen'] ?>" class="img-thumbnail mb-2" style="max-height: 150px;">
                        <?php else: ?>
                            <span class="text-muted">Sin imagen</span>
                        <?php endif; ?>
                        <input type="file" name="imagen" class="form-control mt-2" accept=".jpg,.jpeg,.png,.webp">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Orden</label>
                        <input type="number" name="orden" class="form-control" value="<?= $proyecto['orden'] ?>">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="activo" class="form-check-input" id="activo" <?= $proyecto['activo'] ? 'checked' : '' ?>>
                        <label class="form-check-label" for="activo">Activo</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Actualizar proyecto</button>
                </form>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>