<?php
// Verificar que no se haya instalado ya
if (file_exists('installed.lock')) {
    die('✅ El CMS ya fue instalado. Elimina installed.lock para reinstalar.');
}

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'nullMysql3(');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $sql = file_get_contents('database.sql');

    // Ejecutar cada sentencia por separado
    foreach (array_filter(array_map('trim', explode(';', $sql))) as $query) {
        $pdo->exec($query);
    }

    // Crear archivo de bloqueo para evitar reinstalación
    file_put_contents('installed.lock', date('Y-m-d H:i:s'));

    echo '✅ CMS instalado correctamente. <a href="admin/login.php">Ir al panel</a>';

} catch (PDOException $e) {
    echo '❌ Error durante la instalación: ' . $e->getMessage();
}