<?php
require_once __DIR__ . '/backend/controllers/pedidos/pedidosController.php';
session_start();

if (!isset($_SESSION['idUsuario'])) {
    die("Acceso denegado. Debes iniciar sesión.");
}

$idUsuario = $_SESSION['idUsuario'];
$pedidoController = new PedidoController();
$pedidos = $pedidoController->obtenerPedidosUsuario($idUsuario);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos</title>
    <link rel="stylesheet" href="../assets/css/theme.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Mis Pedidos</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td>#<?php echo htmlspecialchars($pedido['id']); ?></td>
                        <td><?php echo htmlspecialchars($pedido['fecha']); ?></td>
                        <td>$<?php echo number_format($pedido['total'], 2); ?></td>
                        <td>
                            <a href="./verDetallePedidos.php?id=<?php echo $pedido['id']; ?>" class="btn btn-primary btn-sm">Ver Detalles</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="../index.php" class="btn btn-secondary">Volver</a>
    </div>
</body>
</html>
