<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/helpers.php';  

//si ya esta logueado redirigir al dahsboard
if(estalogueado()){
    redirect('admin/index.php');
}
$error = '';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $email = clean($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if($usuario && password_verify($password,$usuario['password_hash'])){
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_email'] = $usuario['email'];
        redirect('admin/index.php');
    } else {
        $error = 'correo o contraseña incorrectos';
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Cat Code CMS</title>
</head>
<body>
    <h2>Iniciar sesión</h2>

    <?php if ($error): ?>
        <?= mensaje($error, 'danger') ?>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Correo" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>