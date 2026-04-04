<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';

$articulos = $pdo->query('SELECT * FROM articulos WHERE publicado = 1 ORDER BY created_at DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog — Nativepress-cms</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/bootstrap.min.css">
    <style>
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark px-4">
        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>/public/index.php">Nativepress-cms</a>
        <a href="<?= BASE_URL ?>/public/index.php" class="text-white text-decoration-none">← Volver al inicio</a>
    </nav>

    <div class="container mt-5">
        <h2 class="fw-bold mb-5 text-center">Blog</h2>

        <?php if (empty($articulos)): ?>
            <p class="text-center text-muted">No hay artículos publicados todavía.</p>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($articulos as $a): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <?php if ($a['imagen_portada']): ?>
                            <img src="<?= BASE_URL ?>/uploads/blog/<?= $a['imagen_portada'] ?>" class="card-img-top" style="height:200px;object-fit:cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?= htmlspecialchars($a['titulo']) ?></h5>
                            <small class="text-muted"><?= date('d/m/Y', strtotime($a['created_at'])) ?></small>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <a href="<?= BASE_URL ?>/public/blog/articulo.php?slug=<?= $a['slug'] ?>" class="btn btn-sm btn-outline-dark">Leer más</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <p class="mb-0">© <?= date('Y') ?> Nativepress-cms — Todos los derechos reservados.</p>
    </footer>

    <script src="<?= BASE_URL ?>/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>