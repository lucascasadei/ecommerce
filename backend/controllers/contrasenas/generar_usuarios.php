<?php
require_once '../../database/Database.php'; // Importar la clase de conexión

set_time_limit(300); // Aumentar el tiempo de ejecución a 5 minutos

$db = new Database();
$conn = $db->getConnection();

// Crear tabla usuarios si no existe con la nueva columna 'estado'
$sql = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_cliente INT(6) UNIQUE NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    estado ENUM('activo', 'inactivo') DEFAULT 'inactivo'
)";
$conn->exec($sql);

// Función para generar contraseñas
function generar_contrasena($codigo_cliente) {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $random = substr(str_shuffle($caracteres), 0, 4); // 4 caracteres aleatorios
    return $codigo_cliente . $random;
}

// Mensaje visual para el usuario
echo "<h2>Generando contraseñas... Por favor, espera.</h2>";
echo "<pre>";
ob_flush();
flush();

// Procesar en lotes
$batch_size = 1000; // Procesa 1000 clientes por iteración
$offset = 0;

try {
    while (true) {
        $stmt = $conn->prepare("SELECT codigo FROM clientes LIMIT :batch_size OFFSET :offset");
        $stmt->bindParam(':batch_size', $batch_size, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        $clientes = $stmt->fetchAll();
        if (empty($clientes)) break; // Si ya no hay más registros, salimos

        $buffer = "";
        foreach ($clientes as $cliente) {
            $codigo_cliente = $cliente['codigo'];
            $usuario = $codigo_cliente;
            $contrasena = generar_contrasena($codigo_cliente);
            $contrasena_hash = password_hash($contrasena, PASSWORD_BCRYPT);
            $estado = 'inactivo'; // Estado por defecto

            $buffer .= "$usuario: $contrasena\n";

            $stmtInsert = $conn->prepare("INSERT IGNORE INTO usuarios (codigo_cliente, usuario, contrasena, estado) VALUES (:codigo_cliente, :usuario, :contrasena, :estado)");
            $stmtInsert->bindParam(":codigo_cliente", $codigo_cliente);
            $stmtInsert->bindParam(":usuario", $usuario);
            $stmtInsert->bindParam(":contrasena", $contrasena_hash);
            $stmtInsert->bindParam(":estado", $estado);
            $stmtInsert->execute();
        }
        
        file_put_contents("contrasenas_guardadas.txt", $buffer, FILE_APPEND); // Escribir en disco una vez por lote
        
        $offset += $batch_size; // Avanzar al siguiente lote
        
        echo "✔ Procesados $offset usuarios...<br>";
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
