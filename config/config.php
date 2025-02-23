<?php
// Detectar si está en local o en producción
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    // Configuración para desarrollo (XAMPP)
    define("DB_HOST", "localhost");
    define("DB_NAME", "ecommerse");
    define("DB_USER", "root");
    define("DB_PASS", "");

    // URL base en local
    define("BASE_URL", "http://localhost/ecommerce");
} else {
    // Configuración para producción (Hostinger)
    define("DB_HOST", "nombre_del_servidor_hostinger"); // Cambia esto en Hostinger
    define("DB_NAME", "nombre_de_tu_base_en_hostinger");
    define("DB_USER", "usuario_hostinger");
    define("DB_PASS", "contraseña_hostinger");

    // Detectar la URL base en producción dinámicamente
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $path = str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname(__DIR__));
    
    define("BASE_URL", "$protocol://$host$path");
}
?>
