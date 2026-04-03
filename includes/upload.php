<?php
function subirImagen($archivo, $carpeta, $prefijo = 'img_') {
    $permitidos  = ['jpg', 'jpeg', 'png', 'webp'];
    $ext         = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

    // Validar formato
    if (!in_array($ext, $permitidos)) {
        return ['error' => 'Formato no permitido. Usa JPG, PNG o WEBP.'];
    }

    // Validar tamaño
    if ($archivo['size'] > MAX_FILE_SIZE) {
        return ['error' => 'La imagen supera el tamaño máximo de 2MB.'];
    }

    // Validar que sea imagen real
    $infoImagen = getimagesize($archivo['tmp_name']);
    if ($infoImagen === false) {
        return ['error' => 'El archivo no es una imagen válida.'];
    }

    // Generar nombre único
    $nombreArchivo = $prefijo . uniqid() . '.' . $ext;
    $destino       = UPLOAD_PATH . '/' . $carpeta . '/' . $nombreArchivo;

    // Mover archivo
    if (!move_uploaded_file($archivo['tmp_name'], $destino)) {
        return ['error' => 'Error al guardar la imagen en el servidor.'];
    }

    return ['archivo' => $nombreArchivo];
}

function eliminarImagen($carpeta, $archivo) {
    if (!$archivo) return;

    $ruta = UPLOAD_PATH . '/' . $carpeta . '/' . $archivo;

    if (file_exists($ruta)) {
        unlink($ruta);
    }
}