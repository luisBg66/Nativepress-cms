<?php

//Redirigir aun URL
function redirect($url) {
    header('Location: ' . BASE_URL . '/' . $url);
    exit;
}

//Linpiar textos para evitar XXL
function clean($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

//Genrar un slug a partir de un titulo
function slugify($text){
 $text = strtolower(trim($text));
 $text = strtr($text,[
    'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
        'ä' => 'a', 'ë' => 'e', 'ï' => 'i', 'ö' => 'o', 'ü' => 'u',
        'ñ' => 'n', 'ç' => 'c'
 ]);
     $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

//verificar si el usuario esta logueado
function estalogueado() {
    return isset($_SESSION['usuario_id']);
}

//proteger paginas del admin
function requireLogin(){
    if(!estalogueado()){
        redirect('admin/login.php');
    }
}

//Mostrar errores o exotos en los formularios
function mensaje($texto, $tipo = 'success'){
    return '<div class="alert alert-' . $tipo . '">' . clean($texto) . '</div>';
}