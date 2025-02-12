<?php
require_once '../../database/Database.php'; // Importar la clase de conexión

$db = new Database();
$conn = $db->getConnection();

// Crear tabla usuarios si no existe
$sql = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_cliente INT(6) UNIQUE NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL
)";
$conn->exec($sql);

// Función para generar contraseñas basadas en el código del cliente
function generar_contrasena($codigo_cliente) {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $random = substr(str_shuffle($caracteres), 0, 4); // 4 caracteres aleatorios
    return $codigo_cliente . $random; // Código del cliente + caracteres aleatorios
}

// Mensaje visual para el usuario
echo "<h2>Generando contraseñas... Por favor, espera.</h2>";
echo "<pre>";
ob_flush();
flush();

// Obtener clientes y generar usuarios
try {
    $stmt = $conn->query("SELECT codigo FROM clientes");
    $clientes = $stmt->fetchAll();

    foreach ($clientes as $cliente) {
        $codigo_cliente = $cliente['codigo'];
        $usuario = $codigo_cliente;
        $contrasena = generar_contrasena($codigo_cliente);
        $contrasena_hash = password_hash($contrasena, PASSWORD_BCRYPT);

        file_put_contents("contrasenas_guardadas.txt", "$usuario: $contrasena\n", FILE_APPEND);

        $stmtInsert = $conn->prepare("INSERT IGNORE INTO usuarios (codigo_cliente, usuario, contrasena) VALUES (:codigo_cliente, :usuario, :contrasena)");
        $stmtInsert->bindParam(":codigo_cliente", $codigo_cliente);
        $stmtInsert->bindParam(":usuario", $usuario);
        $stmtInsert->bindParam(":contrasena", $contrasena_hash);
        $stmtInsert->execute();

        echo "✔ Usuario generado: $usuario<br>";
        ob_flush();
        flush();
    }

    echo "<h3>✅ Todos los usuarios fueron generados correctamente.</h3>";
} catch (PDOException $e) {
    echo "<h3 style='color: red;'>❌ Error: " . $e->getMessage() . "</h3>";
}

// Cerrar conexión
$db->closeConnection();
?>