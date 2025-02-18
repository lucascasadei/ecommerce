<?php
session_start();
require_once '../../backend/controllers/carrito/carrito_controller.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Debes iniciar sesión para ver el carrito'); window.location.href='../login.php';</script>";
    exit();
}

$carritoController = new CarritoController();
$articulosCarrito = $carritoController->obtenerCarritoArray(); // Ya es un array PHP

$totalSubtotal = 0;
if (!empty($articulosCarrito) && is_array($articulosCarrito)) {
    foreach ($articulosCarrito as $item) {
        $subtotalItem = $item['precio'] * $item['cantidad'];
        $totalSubtotal += $subtotalItem;
    }
}

$total = $totalSubtotal;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Carrito de Compras - FreshCart</title>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

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
                                        <img src="./../../<?php echo $item['ruta_imagen']; ?>"
                                            alt="<?php echo $item['descripcion']; ?>" class="img-fluid rounded me-3"
                                            width="80" />
                                        <div>
                                            <h6 class="mb-0"><?php echo $item['descripcion']; ?></h6>
                                            <span
                                                class="text-muted">$<?php echo number_format($item['precio'], 2); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-center">
                                        <button class="btn btn-outline-secondary btn-sm"
                                            onclick="modificarCantidad(<?php echo $item['idArticulo']; ?>, -1)">-</button>
                                        <span id="cantidad-<?php echo $item['idArticulo']; ?>"
                                            class="mx-2"><?php echo $item['cantidad']; ?></span>
                                        <button class="btn btn-outline-secondary btn-sm"
                                            onclick="modificarCantidad(<?php echo $item['idArticulo']; ?>, 1)">+</button>
                                    </div>

                                    <div class="col-md-2 text-end">
                                        <span class="fw-bold">$<?php echo number_format($subtotal, 2); ?></span>
                                    </div>
                                    <div class="col-md-1 text-end">
                                        <button class="btn btn-danger btn-sm"
                                            onclick="eliminarArticulo(<?php echo $item['idArticulo']; ?>)"><i
                                                class="bi bi-trash"></i></button>
                                    </div>
                                </div>
                            </li>
                            <?php }
                            } else { ?>
                            <li class="list-group-item text-center">El carrito está vacío.</li>
                            <?php } ?>
                        </ul>
                        <div class="d-flex justify-content-between mt-4">
                            <a href="../main/ver_todos.php" class="btn btn-primary">Seguir Comprando</a>
                            <!-- <a href="checkout.php" class="btn btn-dark">Proceder al Pago</a> -->
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

                            <li class="list-group-item d-flex justify-content-between fw-bold">
                                <span>Total</span>
                                <strong>$<?php echo number_format($total, 2); ?></strong>
                            </li>
                        </ul>
                        <a href="#" class="btn btn-success w-100 mt-3" onclick="finalizarCompra()">Finalizar Compra</a>


                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
    function eliminarArticulo(id) {
        fetch('../../backend/controllers/carrito/carrito_controller.php', {
                method: 'POST',
                body: new URLSearchParams({
                    accion: 'eliminar',
                    idArticulo: id
                }),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(response => response.json())
            .then(data => location.reload());
    }

    function actualizarCantidad(id, cantidad) {
        fetch('../../backend/controllers/carrito/carrito_controller.php', {
                method: 'POST',
                body: new URLSearchParams({
                    accion: 'actualizar',
                    idArticulo: id,
                    cantidad: cantidad
                }),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(response => response.json())
            .then(data => location.reload());
    }

    function modificarCantidad(id, cambio) {
        let cantidadElemento = document.getElementById("cantidad-" + id);
        let cantidadActual = parseInt(cantidadElemento.textContent);

        let nuevaCantidad = cantidadActual + cambio;

        if (nuevaCantidad < 1) {
            eliminarArticulo(id); // ✅ Si la cantidad es 0, eliminar el artículo
            return;
        }

        // Actualizar visualmente antes de enviar la petición
        cantidadElemento.textContent = nuevaCantidad;

        fetch('../../backend/controllers/carrito/carrito_controller.php', {
                method: 'POST',
                body: new URLSearchParams({
                    accion: 'actualizar',
                    idArticulo: id,
                    cantidad: nuevaCantidad
                }),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(response => response.json())
            .then(data => location.reload());
    }

    function finalizarCompra() {
        fetch('../../backend/controllers/carrito/carrito_controller.php', {
                method: 'POST',
                body: new URLSearchParams({
                    accion: 'finalizarCompra'
                }),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.success);
                    window.location.href = "pedido_confirmado.php?pedido=" + data
                    .pedidoId; // Redirigir a la página de confirmación
                } else {
                    alert(data.error);
                }
            });
    }
    </script>
</body>

</html>