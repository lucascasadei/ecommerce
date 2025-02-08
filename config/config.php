<?php
// Detectar si está en local o en producción
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    // Configuración para desarrollo (XAMPP)
    define("DB_HOST", "localhost");
    define("DB_NAME", "ecommerse");
    define("DB_USER", "root");
    define("DB_PASS", "");
} else {
    // Configuración para producción (Hostinger) - Aquí debes completar con tus datos
    define("DB_HOST", "nombre_del_servidor_hostinger"); // Cambia esto cuando subas a Hostinger
    define("DB_NAME", "nombre_de_tu_base_en_hostinger");
    define("DB_USER", "usuario_hostinger");
    define("DB_PASS", "contraseña_hostinger");
}
?>
