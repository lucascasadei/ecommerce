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
        $stmt = $this->pdo->prepare("SELECT id FROM carrito WHERE idUsuario = ? AND estado = 'pendiente'");
        $stmt->execute([$this->idUsuario]);
        $carrito = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$carrito) {
            $stmt = $this->pdo->prepare("INSERT INTO carrito (idUsuario, estado) VALUES (?, 'pendiente')");
            $stmt->execute([$this->idUsuario]);
            return $this->pdo->lastInsertId();
        }

        return $carrito['id'];
    }

    // ✅ Agregar un artículo al carrito
    public function agregarArticulo($idArticulo, $cantidad) {
        $carritoId = $this->obtenerCarritoId();

        // Verificar si el artículo ya está en el carrito
        $stmt = $this->pdo->prepare("SELECT id, cantidad FROM carrito_detalle WHERE idCarrito = ? AND idArticulo = ?");
        $stmt->execute([$carritoId, $idArticulo]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            $nuevaCantidad = $item['cantidad'] + $cantidad;
            $stmt = $this->pdo->prepare("UPDATE carrito_detalle SET cantidad = ? WHERE id = ?");
            $stmt->execute([$nuevaCantidad, $item['id']]);
        } else {
            $stmt = $this->pdo->prepare("INSERT INTO carrito_detalle (idCarrito, idArticulo, cantidad) VALUES (?, ?, ?)");
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

    // ✅ Obtener los artículos del carrito
    public function obtenerCarrito() {
        $carritoId = $this->obtenerCarritoId();

        $stmt = $this->pdo->prepare("
            SELECT cd.idArticulo, a.descripcion, a.precio, cd.cantidad, a.ruta_imagen 
            FROM carrito_detalle cd
            JOIN articulos a ON cd.idArticulo = a.id
            WHERE cd.idCarrito = ?
        ");
        $stmt->execute([$carritoId]);
        $articulos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($articulos);
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
        case "obtener":
            $carrito->obtenerCarrito();
            break;
        default:
            echo json_encode(["error" => "Acción no válida."]);
    }
}
?>
