<?php
session_start();
require_once '../../database/Database.php';

header('Content-Type: application/json'); // Indicar que la respuesta será JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);

    if (empty($usuario) || empty($contrasena)) {
        echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios."]);
        exit();
    }

    try {
        $db = new Database();
        $pdo = $db->getConnection();

        $stmt = $pdo->prepare("SELECT id, codigo_cliente, usuario, contrasena, estado FROM usuarios WHERE usuario = :usuario");
        $stmt->bindParam(":usuario", $usuario);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user) {
            if (password_verify($contrasena, $user['contrasena'])) {
                if ($user['estado'] === 'inactivo') {
                    $updateStmt = $pdo->prepare("UPDATE usuarios SET estado = 'activo' WHERE id = :id");
                    $updateStmt->bindParam(":id", $user['id']);
                    $updateStmt->execute();
                }

                // Iniciar sesión
                $_SESSION['usuario'] = $user['usuario'];
                $_SESSION['codigo_cliente'] = $user['codigo_cliente'];
                $_SESSION['id'] = $user['id'];
                $_SESSION['estado'] = 'activo';

                echo json_encode(["status" => "success", "message" => "Inicio de sesión exitoso."]);
                exit();
            } else {
                echo json_encode(["status" => "error", "message" => "Contraseña incorrecta."]);
                exit();
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Usuario no encontrado."]);
            exit();
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Error en la conexión con la base de datos."]);
        exit();
    }
}
?>
