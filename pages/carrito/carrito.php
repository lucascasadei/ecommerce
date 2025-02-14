<?php
session_start();
require_once '../../backend/controllers/carrito/carrito_controller.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Debes iniciar sesión para ver el carrito'); window.location.href='../login.php';</script>";
    exit();
}

$carritoController = new CarritoController();
$articulosCarrito = json_decode($carritoController->obtenerCarrito(), true);

$totalSubtotal = 0;
if (!empty($articulosCarrito) && is_array($articulosCarrito)) {
    foreach ($articulosCarrito as $item) {
        $subtotalItem = $item['precio'] * $item['cantidad'];
        $totalSubtotal += $subtotalItem;
    }
}
$envio = 5.00;
$total = $totalSubtotal + $envio;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Carrito de Compras - FreshCart</title>
    <link rel="stylesheet" href="./../../dist/assets/css/theme.min.css" />
</head>
<body>
    <main class="mt-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-7">
                    <div class="py-3">
                        <h2 class="fw-bold">Carrito de Compras</h2>
                        <ul class="list-group list-group-flush">
                            <?php if (!empty($articulosCarrito)) {
                                foreach ($articulosCarrito as $item) {
                                    $subtotal = $item['precio'] * $item['cantidad']; ?>
                                    <li class="list-group-item py-3 border-top">
                                        <div class="row align-items-center">
                                            <div class="col-md-6 d-flex">
                                                <img src="./../../dist/assets/images/products/<?php echo $item['ruta_imagen']; ?>" alt="<?php echo $item['descripcion']; ?>" class="img-fluid rounded me-3" width="80" />
                                                <div>
                                                    <h6 class="mb-0"><?php echo $item['descripcion']; ?></h6>
                                                    <span class="text-muted">$<?php echo number_format($item['precio'], 2); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" class="form-control" value="<?php echo $item['cantidad']; ?>" min="1" max="99" onchange="actualizarCantidad(<?php echo $item['idArticulo']; ?>, this.value)" />
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <span class="fw-bold">$<?php echo number_format($subtotal, 2); ?></span>
                                            </div>
                                            <div class="col-md-1 text-end">
                                                <button class="btn btn-danger btn-sm" onclick="eliminarArticulo(<?php echo $item['idArticulo']; ?>)"><i class="bi bi-trash"></i></button>
                                            </div>
                                        </div>
                                    </li>
                                <?php }
                            } else { ?>
                                <li class="list-group-item text-center">El carrito está vacío.</li>
                            <?php } ?>
                        </ul>
                        <div class="d-flex justify-content-between mt-4">
                            <a href="../index.php" class="btn btn-primary">Seguir Comprando</a>
                            <a href="checkout.php" class="btn btn-dark">Proceder al Pago</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5">
                    <div class="card p-4">
                        <h4 class="fw-bold">Resumen</h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Subtotal</span>
                                <strong>$<?php echo number_format($totalSubtotal, 2); ?></strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Envío</span>
                                <strong>$<?php echo number_format($envio, 2); ?></strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between fw-bold">
                                <span>Total</span>
                                <strong>$<?php echo number_format($total, 2); ?></strong>
                            </li>
                        </ul>
                        <a href="checkout.php" class="btn btn-success w-100 mt-3">Finalizar Compra</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        function eliminarArticulo(id) {
            fetch('../../backend/controllers/carrito/carrito_controller.php', {
                method: 'POST',
                body: JSON.stringify({ accion: 'eliminar', idArticulo: id }),
                headers: { 'Content-Type': 'application/json' }
            }).then(response => response.json())
              .then(data => location.reload());
        }
        function actualizarCantidad(id, cantidad) {
            fetch('../../backend/controllers/carrito/carrito_controller.php', {
                method: 'POST',
                body: JSON.stringify({ accion: 'actualizar', idArticulo: id, cantidad: cantidad }),
                headers: { 'Content-Type': 'application/json' }
            }).then(response => response.json())
              .then(data => location.reload());
        }
    </script>
</body>
</html>
