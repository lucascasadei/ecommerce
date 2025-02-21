<?php
require_once __DIR__ . '/../../backend/controllers/pedidos/pedidosController.php';


if (!isset($_SESSION['id'])) {
    die("Acceso denegado. Debes iniciar sesión.");
}

$idUsuario = $_SESSION['id'];
$pedidoController = new PedidoController();
$pedidos = $pedidoController->obtenerPedidosUsuario($idUsuario);
?>

<!DOCTYPE html>
<html lang="es">
   <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta content="Codescandy" name="author" />
      <title>Mis Pedidos - FreshCart</title>
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
                        <li class="breadcrumb-item active" aria-current="page">Mis Pedidos</li>
                     </ol>
                  </nav>
               </div>
            </div>

            <!-- Título -->
            <div class="row">
               <div class="col-12">
                  <h1 class="fw-bold mb-4">Mis Pedidos</h1>
               </div>
            </div>

            <!-- Tabla de Pedidos -->
            <div class="row">
               <div class="col-12">
                  <div class="card shadow-sm">
                     <div class="card-body p-4">
                        <div class="table-responsive">
                           <table class="table table-hover align-middle">
                              <thead class="table-dark">
                                 <tr>
                                    <th>ID Pedido</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php if (empty($pedidos)): ?>
                                    <tr>
                                       <td colspan="4" class="text-center">No tienes pedidos aún.</td>
                                    </tr>
                                 <?php else: ?>
                                    <?php foreach ($pedidos as $pedido): ?>
                                       <tr>
                                          <td>#<?php echo htmlspecialchars($pedido['id']); ?></td>
                                          <td><?php echo htmlspecialchars($pedido['fecha']); ?></td>
                                          <td>$<?php echo number_format($pedido['total'], 2); ?></td>
                                          <td>
                                             <a href="./verDetallePedidos.php?id=<?php echo $pedido['id']; ?>" class="btn btn-primary btn-sm">
                                                <i class="feather-icon icon-eye"></i> Ver Detalles
                                             </a>
                                          </td>
                                       </tr>
                                    <?php endforeach; ?>
                                 <?php endif; ?>
                              </tbody>
                           </table>
                        </div>
                        <div class="mt-4">
                           <a href="index.php" class="btn btn-secondary"><i class="feather-icon icon-arrow-left"></i> Volver</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </main>

      <!-- Scripts -->
      <script src="./../../dist/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
      <script src="./../../dist/assets/libs/simplebar/dist/simplebar.min.js"></script>
      <script src="./../../dist/assets/js/theme.min.js"></script>
   </body>
</html>
