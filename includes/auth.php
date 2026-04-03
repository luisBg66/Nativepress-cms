<?php
function verificarSecion(){
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }
    if(!isset($_SESSION['usuario_id'])){
        header('Location: ../admin/login.php');
        exit;
    }

    function cerrarSesion(){}
        if(session_status()==PHP_SESSION_NONE){
            session_start();
        }
        $_SESSION = [];
        session_destroy();
        header('Location: ../admin/login.php');
        exit;

    }
function usuarioActual() {
    return $_SESSION['usuario_email'] ?? null;
}

