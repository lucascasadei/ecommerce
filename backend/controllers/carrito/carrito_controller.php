<?php
require_once __DIR__ . '/../../database/Database.php';

// Verificar si la sesión no ha sido iniciada antes de llamarla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class CarritoController {
    private $pdo;
    private $idUsuario;

    public function __construct() {
        $database = new Database();
        $this->pdo = $database->getConnection();

        if (!isset($_SESSION['id'])) {
            die(json_encode(["error" => "⚠️ Debes iniciar sesión para gestionar el carrito."]));
        }

        $this->idUsuario = $_SESSION['id'];
    }

    // ✅ Obtener el ID del carrito pendiente del usuario
    private function obtenerCarritoId() {
        $stmt = $this->pdo->prepare("SELECT id FROM carrito WHERE idUsuario = ?");
        $stmt->execute([$this->idUsuario]);
        $carrito = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$carrito) {
            $stmt = $this->pdo->prepare("INSERT INTO carrito (idUsuario) VALUES (?)");
            $stmt->execute([$this->idUsuario]);
            return $this->pdo->lastInsertId();
        }

        return $carrito['id'];
    }

    // ✅ Agregar un artículo al carrito con estado 'pendiente'
    public function agregarArticulo($idArticulo, $cantidad) {
        $carritoId = $this->obtenerCarritoId();

        // Verificar si el artículo ya está en el carrito
        $stmt = $this->pdo->prepare("SELECT id, cantidad FROM carrito_detalle WHERE idCarrito = ? AND idArticulo = ? AND estado = 'pendiente'");
        $stmt->execute([$carritoId, $idArticulo]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            $nuevaCantidad = $item['cantidad'] + $cantidad;
            $stmt = $this->pdo->prepare("UPDATE carrito_detalle SET cantidad = ? WHERE id = ?");
            $stmt->execute([$nuevaCantidad, $item['id']]);
        } else {
            $stmt = $this->pdo->prepare("INSERT INTO carrito_detalle (idCarrito, idArticulo, cantidad, estado) VALUES (?, ?, ?, 'pendiente')");
            $stmt->execute([$carritoId, $idArticulo, $cantidad]);
        }

        echo json_encode(["success" => "✅ Artículo agregado al carrito."]);
    }

    // ✅ Eliminar un artículo del carrito
    public function eliminarArticulo($idArticulo) {
        $carritoId = $this->obtenerCarritoId();
        $stmt = $this->pdo->prepare("DELETE FROM carrito_detalle WHERE idCarrito = ? AND idArticulo = ?");
        $stmt->execute([$carritoId, $idArticulo]);

        echo json_encode(["success" => "✅ Artículo eliminado del carrito."]);
    }

    // ✅ Actualizar cantidad de un artículo en el carrito
    public function actualizarCantidad($idArticulo, $cantidad) {
        $carritoId = $this->obtenerCarritoId();
        $stmt = $this->pdo->prepare("UPDATE carrito_detalle SET cantidad = ? WHERE idCarrito = ? AND idArticulo = ?");
        $stmt->execute([$cantidad, $carritoId, $idArticulo]);

        echo json_encode(["success" => "✅ Cantidad actualizada en el carrito."]);
    }

    // ✅ Actualizar estado de un artículo (Ejemplo: marcar como 'comprado')
    public function actualizarEstadoArticulo($idArticulo, $estado) {
        $carritoId = $this->obtenerCarritoId();
        $stmt = $this->pdo->prepare("UPDATE carrito_detalle SET estado = ? WHERE idCarrito = ? AND idArticulo = ?");
        $stmt->execute([$estado, $carritoId, $idArticulo]);

        echo json_encode(["success" => "✅ Estado del artículo actualizado a '$estado'."]);
    }

    // ✅ Obtener los artículos del carrito con su estado
  // ✅ Obtener los artículos del carrito con su cantidad
public function obtenerCarrito() {
    $carritoId = $this->obtenerCarritoId();

    $stmt = $this->pdo->prepare("
        SELECT cd.idArticulo, a.descripcion, a.precio, cd.cantidad, a.ruta_imagen, cd.estado 
        FROM carrito_detalle cd
        JOIN articulos a ON cd.idArticulo = a.id
        WHERE cd.idCarrito = ?
    ");
    $stmt->execute([$carritoId]);
    $articulos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($articulos); // 🔹 Devuelve la cantidad en JSON
}

// ✅ Nueva función que devuelve el carrito en un array sin imprimir JSON
public function obtenerCarritoArray() {
    $carritoId = $this->obtenerCarritoId();

    $stmt = $this->pdo->prepare("
        SELECT cd.idArticulo, a.descripcion, a.precio, cd.cantidad, a.ruta_imagen, cd.estado 
        FROM carrito_detalle cd
        JOIN articulos a ON cd.idArticulo = a.id
        WHERE cd.idCarrito = ?
    ");
    $stmt->execute([$carritoId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    
}

// ✅ Capturar acción desde AJAX o formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $carrito = new CarritoController();
    $accion = $_POST['accion'];

    switch ($accion) {
        case "agregar":
            $carrito->agregarArticulo($_POST['idArticulo'], $_POST['cantidad']);
            break;
        case "eliminar":
            $carrito->eliminarArticulo($_POST['idArticulo']);
            break;
        case "actualizar":
            $carrito->actualizarCantidad($_POST['idArticulo'], $_POST['cantidad']);
            break;
        case "actualizarEstado":
            $carrito->actualizarEstadoArticulo($_POST['idArticulo'], $_POST['estado']);
            break;
        case "obtener":
            $carrito->obtenerCarrito();
            break;
        default:
            echo json_encode(["error" => "Acción no válida."]);
    }
}
?>