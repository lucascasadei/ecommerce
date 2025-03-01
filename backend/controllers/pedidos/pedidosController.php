<?php
require_once __DIR__ . '/../../database/Database.php';

session_start(); // Asegurar que la sesión está iniciada

class PedidoController {
    private $pdo;

    public function __construct() {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    // Obtener todos los pedidos del usuario actual
    public function obtenerPedidosUsuario($idUsuario) {
        $sql = "SELECT id, fecha, total FROM pedidos WHERE idUsuario = :idUsuario ORDER BY fecha DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Obtener los detalles de un pedido específico
    public function obtenerPedido($idPedido, $idUsuario) {
        $sql = "SELECT 
                    p.id AS idPedido,
                    p.fecha,
                    p.total,
                    pd.idArticulo,
                    a.descripcion,
                    COALESCE(i.ruta_imagen, 'assets/imagenes/articulos/default.png') AS ruta_imagen,
                    pd.cantidad AS cantidadPedida,
                    a.precio AS precioUnitario,
                    (pd.cantidad * a.precio) AS subtotal
                FROM pedido_detalle pd
                JOIN pedidos p ON pd.idPedido = p.id
                JOIN articulos a ON pd.idArticulo = a.id
                LEFT JOIN imagenes_articulos i ON a.codigo_generico = i.codigo_generico
                WHERE p.id = :idPedido AND p.idUsuario = :idUsuario";
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":idPedido", $idPedido, PDO::PARAM_INT);
        $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
}
?>
