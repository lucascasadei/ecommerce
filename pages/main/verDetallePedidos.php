<?php
require_once __DIR__ . '/backend/controllers/pedidos/pedidosController.php';
session_start();

if (!isset($_SESSION['idUsuario'])) {
    die("Acceso denegado. Debes iniciar sesión.");
}

$idUsuario = $_SESSION['idUsuario'];
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
      <link rel="stylesheet" href="../assets/css/theme.min.css" />
   </head>
   <body>
      <main>
         <div class="container mt-4">
            <h2>Detalles del Pedido #<?php echo htmlspecialchars($idPedido); ?></h2>
            <div class="row">
               <div class="col-lg-8">
                  <div class="card shadow-sm">
                     <h5 class="px-6 py-4 bg-transparent mb-0">Productos en el Pedido</h5>
                     <ul class="list-group list-group-flush">
                        <?php foreach ($detallesPedido as $item): ?>
                           <li class="list-group-item px-4 py-3">
                              <div class="row align-items-center">
                                 <div class="col-5">
                                    <h6><?php echo htmlspecialchars($item['nombreArticulo']); ?></h6>
                                    <small class="text-muted"><?php echo htmlspecialchars($item['descripcion']); ?></small>
                                 </div>
                                 <div class="col-2 text-center"><?php echo htmlspecialchars($item['cantidadPedida']); ?></div>
                                 <div class="col-2 text-end">$<?php echo number_format($item['precioUnitario'], 2); ?></div>
                                 <div class="col-3 text-end fw-bold">$<?php echo number_format($item['subtotal'], 2); ?></div>
                              </div>
                           </li>
                        <?php endforeach; ?>
                        <li class="list-group-item px-4 py-3">
                           <div class="d-flex justify-content-between fw-bold">
                              <div>Total</div>
                              <div>$<?php echo number_format(array_sum(array_column($detallesPedido, 'subtotal')), 2); ?></div>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
            <a href="pedidos.php" class="btn btn-secondary mt-3">Volver</a>
         </div>
      </main>
      <script src="../assets/js/theme.min.js"></script>
   </body>
</html>
