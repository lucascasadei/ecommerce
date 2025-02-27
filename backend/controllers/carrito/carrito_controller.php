<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

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
        WHERE cd.idCarrito = ? AND cd.estado = 'pendiente'
    ");
    $stmt->execute([$carritoId]);
    $articulos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($articulos); // 🔹 Devuelve solo los artículos pendientes en JSON
}


// ✅ Nueva función que devuelve el carrito en un array sin imprimir JSON
public function obtenerCarritoArray() {
    $carritoId = $this->obtenerCarritoId();

    $stmt = $this->pdo->prepare("
        SELECT cd.idArticulo, a.descripcion, a.precio, cd.cantidad, a.ruta_imagen, cd.estado 
        FROM carrito_detalle cd
        JOIN articulos a ON cd.idArticulo = a.id
        WHERE cd.idCarrito = ? AND cd.estado = 'pendiente'
    ");
    $stmt->execute([$carritoId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function finalizarCompra() {
    try {
        $this->pdo->beginTransaction(); // 🔹 Iniciar una transacción para evitar inconsistencias

        $carritoId = $this->obtenerCarritoId();
        
        // Obtener los artículos del carrito que están en estado "pendiente"
        $stmt = $this->pdo->prepare("
            SELECT cd.idArticulo, cd.cantidad, a.precio 
            FROM carrito_detalle cd
            JOIN articulos a ON cd.idArticulo = a.id
            WHERE cd.idCarrito = ? AND cd.estado = 'pendiente'
        ");
        $stmt->execute([$carritoId]);
        $articulosCarrito = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($articulosCarrito)) {
            echo json_encode(["error" => "⚠️ No hay artículos pendientes en el carrito."]);
            return;
        }

        // Calcular total del pedido
        $total = 0;
        foreach ($articulosCarrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        // Configurar la zona horaria de Buenos Aires
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fechaBuenosAires = date('Y-m-d H:i:s'); // Obtener la fecha en el formato correcto

        // Insertar nuevo pedido en la tabla `pedidos`
        $stmt = $this->pdo->prepare("INSERT INTO pedidos (idUsuario, fecha, total) VALUES (?, ?, ?)");
        $stmt->execute([$this->idUsuario, $fechaBuenosAires, $total]);
        $pedidoId = $this->pdo->lastInsertId();

        // Insertar los detalles del pedido en la tabla `pedido_detalle`
        $stmt = $this->pdo->prepare("INSERT INTO pedido_detalle (idPedido, idArticulo, cantidad, precio) VALUES (?, ?, ?, ?)");
        foreach ($articulosCarrito as $item) {
            $stmt->execute([$pedidoId, $item['idArticulo'], $item['cantidad'], $item['precio']]);
        }

        // Actualizar los artículos en `carrito_detalle` para marcar su estado como "comprado"
        $stmt = $this->pdo->prepare("UPDATE carrito_detalle SET estado = 'comprado' WHERE idCarrito = ? AND estado = 'pendiente'");
        $stmt->execute([$carritoId]);

        $this->pdo->commit(); // 🔹 Confirmar la transacción
        echo json_encode(["success" => "✅ Compra finalizada correctamente.", "pedidoId" => $pedidoId]);

    } catch (Exception $e) {
        $this->pdo->rollBack(); // 🔹 Revertir la transacción si hay error
        echo json_encode(["error" => "❌ Error al procesar la compra: " . $e->getMessage()]);
    }
}

public function buscarArticulosPorDescripcion($termino) {
    try {
        if (empty(trim($termino))) {
            echo json_encode(["error" => "⚠️ Ingresa un término de búsqueda válido."]);
            exit;
        }

        $stmt = $this->pdo->prepare("
            SELECT id, codigo_generico, descripcion, precio, ruta_imagen 
            FROM articulos 
           WHERE descripcion LIKE ? 
            AND codigo_generico NOT LIKE 'KIT%' 
            AND codigo_generico NOT LIKE 'KL%'

        ");

        $stmt->execute(['%' . $termino . '%']);
        $articulosEncontrados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$articulosEncontrados) {
            echo json_encode(["error" => "⚠️ No se encontraron productos."]);
        } else {
            echo json_encode($articulosEncontrados);
        }
    } catch (Exception $e) {
        echo json_encode(["error" => "❌ Error en la consulta: " . $e->getMessage()]);
    }
    exit;
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
        case "finalizarCompra":
            $carrito->finalizarCompra();
            break;
        case "buscarArticulo":
            if (isset($_POST['termino']) && !empty(trim($_POST['termino']))) {
                $carrito->buscarArticulosPorDescripcion($_POST['termino']);
            } else {
                echo json_encode(["error" => "⚠️ Debes ingresar un término de búsqueda válido."]);
            }
            break;
                
        
        default:
            echo json_encode(["error" => "Acción no válida."]);
    }
}
?>