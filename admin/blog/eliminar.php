<?php
session_start();
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';

requireLogin();

$id = (int)($_GET['id'] ?? 0);

if ($id) {
    $stmt = $pdo->prepare('SELECT imagen_portada FROM articulos WHERE id = ?');
    $stmt->execute([$id]);
    $articulo = $stmt->fetch();

    if ($articulo) {
        // Eliminar imagen si existe
        if ($articulo['imagen_portada'] && file_exists(UPLOAD_PATH . '/blog/' . $articulo['imagen_portada'])) {
            unlink(UPLOAD_PATH . '/blog/' . $articulo['imagen_portada']);
        }

        $stmt = $pdo->prepare('DELETE FROM articulos WHERE id = ?');
        $stmt->execute([$id]);
    }
}

redirect('admin/blog/index.php');