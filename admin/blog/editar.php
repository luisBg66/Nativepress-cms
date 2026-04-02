<?php
session_start();
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';

requireLogin();

$id = (int)($_GET['id'] ?? 0);

if (!$id) {
    redirect('admin/blog/index.php');
}

$stmt = $pdo->prepare('SELECT * FROM articulos WHERE id = ?');
$stmt->execute([$id]);
$articulo = $stmt->fetch();

if (!$articulo) {
    redirect('admin/blog/index.php');
}

$error = '';
$exito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo         = clean($_POST['titulo'] ?? '');
    $contenido      = $_POST['contenido'] ?? '';
    $publicado      = isset($_POST['publicado']) ? 1 : 0;
    $imagen_portada = $articulo['imagen_portada'];

    if (empty($titulo)) {
        $error = 'El título es obligatorio.';
    } else {
        // Manejo de imagen nueva
        if (!empty($_FILES['imagen_portada']['name'])) {
            $ext        = strtolower(pathinfo($_FILES['imagen_portada']['name'], PATHINFO_EXTENSION));
            $permitidos = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($ext, $permitidos)) {
                $error = 'Formato de imagen no permitido.';
            } elseif ($_FILES['imagen_portada']['size'] > MAX_FILE_SIZE) {
                $error = 'La imagen supera el tamaño máximo de 2MB.';
            } else {
                $nombreArchivo = uniqid('blog_') . '.' . $ext;
                $destino       = UPLOAD_PATH . '/blog/' . $nombreArchivo;

                if (move_uploaded_file($_FILES['imagen_portada']['tmp_name'], $destino)) {
                    // Eliminar imagen anterior
                    if ($articulo['imagen_portada'] && file_exists(UPLOAD_PATH . '/blog/' . $articulo['imagen_portada'])) {
                        unlink(UPLOAD_PATH . '/blog/' . $articulo['imagen_portada']);
                    }
                    $imagen_portada = $nombreArchivo;
                } else {
                    $error = 'Error al subir la imagen.';
                }
            }
        }

        if (empty($error)) {
            $stmt = $pdo->prepare('UPDATE articulos SET titulo = ?, contenido = ?, imagen_portada = ?, publicado = ? WHERE id = ?');
            $stmt->execute([$titulo, $contenido, $imagen_portada, $publicado, $id]);
            $exito = 'Artículo actualizado correctamente.';

            $stmt = $pdo->prepare('SELECT * FROM articulos WHERE id = ?');
            $stmt->execute([$id]);
            $articulo = $stmt->fetch();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Artículo — Cat Code CMS</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/bootstrap.min.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#contenido',
            language: 'es',
            plugins: 'lists link image code',
            toolbar: 'undo redo | bold italic | bullist numlist | link image | code',
            height: 400
        });
    </script>
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

    <div class="container mt-5" style="max-width: 800px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Editar Artículo</h4>
            <a href="<?= BASE_URL ?>/admin/blog/index.php" class="btn btn-sm btn-secondary">← Volver</a>
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
                        <input type="text" name="titulo" class="form-control" value="<?= clean($articulo['titulo']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contenido</label>
                        <textarea name="contenido" id="contenido" class="form-control"><?= $articulo['contenido'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Imagen de portada actual</label><br>
                        <?php if ($articulo['imagen_portada']): ?>
                            <img src="<?= BASE_URL ?>/uploads/blog/<?= $articulo['imagen_portada'] ?>" class="img-thumbnail mb-2" style="max-height: 150px;">
                        <?php else: ?>
                            <span class="text-muted">Sin imagen</span>
                        <?php endif; ?>
                        <input type="file" name="imagen_portada" class="form-control mt-2" accept=".jpg,.jpeg,.png,.webp">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="publicado" class="form-check-input" id="publicado" <?= $articulo['publicado'] ? 'checked' : '' ?>>
                        <label class="form-check-label" for="publicado">Publicar artículo</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Actualizar artículo</button>
                </form>
            </div>
        </div>
    </div>

   <script src="<?= BASE_URL ?>/public/assets/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#contenido',
        plugins: 'lists link image code',
        toolbar: 'undo redo | bold italic | bullist numlist | link image | code',
        height: 400,
        license_key: 'gpl'
    });
</script>
</body>
</html>