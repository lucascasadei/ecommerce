<?php
require_once 'config.php'; // Incluye tu configuración de la base de datos

try {
    // Intenta conectar a la base de datos
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ejecuta una consulta de prueba
    $stmt = $pdo->query("SHOW TABLES");
    
    echo "<h2>✅ Conexión exitosa a la base de datos</h2>";
    echo "<h3>Tablas en la base de datos:</h3><ul>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>" . implode("", $row) . "</li>"; // Muestra las tablas
    }
    echo "</ul>";
} catch (PDOException $e) {
    echo "<h2>❌ Error de conexión: " . $e->getMessage() . "</h2>";
}
?>
