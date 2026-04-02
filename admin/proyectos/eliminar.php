<?php
session_start();
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';

requireLogin();

$id = (int)($_GET['id'] ?? 0);

if ($id) {
    $stmt = $pdo->prepare('SELECT imagen FROM proyectos WHERE id = ?');
    $stmt->execute([$id]);
    $proyecto = $stmt->fetch();

    if ($proyecto) {
        // Eliminar imagen si existe
        if ($proyecto['imagen'] && file_exists(UPLOAD_PATH . '/proyectos/' . $proyecto['imagen'])) {
            unlink(UPLOAD_PATH . '/proyectos/' . $proyecto['imagen']);
        }

        $stmt = $pdo->prepare('DELETE FROM proyectos WHERE id = ?');
        $stmt->execute([$id]);
    }
}

redirect('admin/proyectos/index.php');