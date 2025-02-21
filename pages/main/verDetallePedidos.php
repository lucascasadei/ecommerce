<?php
require_once __DIR__ . '/../../backend/controllers/pedidos/pedidosController.php';


if (!isset($_SESSION['id'])) {
    die("Acceso denegado. Debes iniciar sesión.");
}

$idUsuario = $_SESSION['id'];
$idPedido = isset($_GET['id']) ? intval($_GET['id']) : 0;

$pedidoController = new PedidoController();
$detallesPedido = $pedidoController->obtenerPedido($idPedido, $idUsuario);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Detalles del Pedido - FreshCart</title>
    <link rel="shortcut icon" type="image/x-icon" href="./../../dist/assets/images/favicon/favicon.ico" />
    <link href="./../../dist/assets/libs/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link href="./../../dist/assets/libs/feather-webfont/dist/feather-icons.css" rel="stylesheet" />
    <link href="./../../dist/assets/libs/simplebar/dist/simplebar.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./../../dist/assets/css/theme.min.css" />
</head>

<body>
    <main>
        <div class="container mt-4">
            <!-- Breadcrumb -->
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="pedidos.php">Mis Pedidos</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detalles del Pedido</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Título -->
            <div class="row">
                <div class="col-12">
                    <h1 class="fw-bold mb-4">Detalles del Pedido #<?php echo htmlspecialchars($idPedido); ?></h1>
                </div>
            </div>

            <!-- Detalles del Pedido -->
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="card shadow-sm">
                        <h5 class="px-6 py-4 bg-transparent mb-0">Productos en el Pedido</h5>
                        <ul class="list-group list-group-flush">
                            <?php if (empty($detallesPedido)): ?>
                            <li class="list-group-item text-center">No se encontraron productos en este pedido.</li>
                            <?php else: ?>
                            <?php foreach ($detallesPedido as $item): ?>
                            <li class="list-group-item px-4 py-3">
                                <div class="row align-items-center">
                                    <div class="col-md-2 col-4">
                                        <img src="<?php echo htmlspecialchars('../../' . $item['ruta_imagen']); ?>" alt=""
                                            class="img-fluid rounded">
                                    </div>

                                    <div class="col-md-4 col-8">
                                        <small
                                            class="text-muted"><?php echo htmlspecialchars($item['descripcion']); ?></small>
                                    </div>
                                    <div class="col-md-2 col-4 text-center">
                                        <span
                                            class="fw-bold"><?php echo htmlspecialchars($item['cantidadPedida']); ?></span>
                                    </div>
                                    <div class="col-md-2 col-4 text-end">
                                        <span>$<?php echo number_format($item['precioUnitario'], 2); ?></span>
                                    </div>
                                    <div class="col-md-2 col-4 text-end fw-bold">
                                        <span>$<?php echo number_format($item['subtotal'], 2); ?></span>
                                    </div>
                                </div>
                            </li>
                            <?php endforeach; ?>
                            <li class="list-group-item px-4 py-3">
                                <div class="d-flex justify-content-between fw-bold">
                                    <div>Total del Pedido</div>
                                    <div>
                                        $<?php echo number_format(array_sum(array_column($detallesPedido, 'subtotal')), 2); ?>
                                    </div>
                                </div>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Botón de regreso -->
            <div class="mt-4">
                <a href="./verPedidos.php" class="btn btn-secondary"><i class="feather-icon icon-arrow-left"></i>
                    Volver</a>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="./../../dist/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./../../dist/assets/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="./../../dist/assets/js/theme.min.js"></script>
</body>

</html>