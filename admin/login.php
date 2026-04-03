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
    <link rel="stylesheet" href="/public/assets/css/bootstrap.min.css">
    <style>
        body {
            min-height: 100vh;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.08);
            padding: 2.5rem 2rem 2rem 2rem;
            max-width: 350px;
            width: 100%;
        }
        .login-logo {
            width: 60px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="login-container mx-auto">
        <div class="text-center mb-3">
            <img src="/public/assets/img/logo.png" alt="Logo" class="login-logo" onerror="this.style.display='none'">
            <h3 class="mb-0">Iniciar sesión</h3>
            <small class="text-muted">Panel de administración</small>
        </div>
        <?php if ($error): ?>
            <?= mensaje($error, 'danger') ?>
        <?php endif; ?>
        <form method="POST" autocomplete="off">
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required autofocus>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
    </div>
    <script src="/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>