<?php
//configuracion de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'nombre_de_la_base_de_datos');
define('DB_USER', 'usuario_de_la_base_de_datos');
define('DB_PASS', 'contraseña_de_la_base_de_datos');

//URL base del proyecto
define('BASE_URL', 'http://localhost/tu_proyecto/');

//ruta del servidor 
define('BASE_PATH', __DIR__. '/..');

// Configuración de uploads
define('UPLOAD_PATH', BASE_PATH . '/uploads');
define('MAX_FILE_SIZE', 2 * 1024 * 1024); // 2MB