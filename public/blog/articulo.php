<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';

$slug = clean($_GET['slug'] ?? '');

if (!$slug) {
    header('Location: ' . BASE_URL . '/public/blog/index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM articulos WHERE slug = ? AND publicado = 1');
$stmt->execute([$slug]);
$articulo = $stmt->fetch();

if (!$articulo) {
    header('Location: ' . BASE_URL . '/public/blog/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($articulo['titulo']) ?> — Cat Code</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/bootstrap.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark px-4">
        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>/public/index.php">Cat Code</a>
        <a href="<?= BASE_URL ?>/public/blog/index.php" class="text-white text-decoration-none">← Volver al blog</a>
    </nav>

    <div class="container mt-5" style="max-width: 800px;">

        <?php if ($articulo['imagen_portada']): ?>
            <img src="<?= BASE_URL ?>/uploads/blog/<?= $articulo['imagen_portada'] ?>" class="img-fluid rounded mb-4 w-100" style="max-height:400px;object-fit:cover;">
        <?php endif; ?>

        <h1 class="fw-bold mb-2"><?= htmlspecialchars($articulo['titulo']) ?></h1>
        <small class="text-muted d-block mb-4"><?= date('d/m/Y', strtotime($articulo['created_at'])) ?></small>

        <hr>

        <div class="mt-4 lh-lg">
            <?= $articulo['contenido'] ?>
        </div>

        <div class="mt-5 text-center">
            <a href="<?= BASE_URL ?>/public/blog/index.php" class="btn btn-outline-dark">← Ver todos los artículos</a>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <p class="mb-0">© <?= date('Y') ?> Cat Code — Todos los derechos reservados.</p>
    </footer>

    <script src="<?= BASE_URL ?>/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>