<?php
//configuracion de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'catcode_cms');
define('DB_USER', 'root');
define('DB_PASS', 'nullMysql3(');

//URL base del proyecto
define('BASE_URL', 'http://localhost:8001');

//ruta del servidor 
define('BASE_PATH', __DIR__. '/..');

// Configuración de uploads
define('UPLOAD_PATH', BASE_PATH . '/uploads');
define('MAX_FILE_SIZE', 2 * 1024 * 1024); // 2MB