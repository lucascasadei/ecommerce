<?php
require_once '../../backend/database/Database.php';

$database = new Database();
$pdo = $database->getConnection();

// Obtener grupos (ordenamiento1) y subgrupos (ordenamiento2) únicos
$stmt_grupos = $pdo->prepare("SELECT DISTINCT ordenamiento1 FROM articulos WHERE ordenamiento1 IS NOT NULL ORDER BY ordenamiento1");
$stmt_grupos->execute();
$grupos = $stmt_grupos->fetchAll(PDO::FETCH_ASSOC);

$stmt_subgrupos = $pdo->prepare("SELECT DISTINCT ordenamiento2 FROM articulos WHERE ordenamiento2 IS NOT NULL ORDER BY ordenamiento2");
$stmt_subgrupos->execute();
$subgrupos = $stmt_subgrupos->fetchAll(PDO::FETCH_ASSOC);

// Obtener productos con precio mayor a 0
$stmt_productos = $pdo->prepare("SELECT id, codigo_generico, descripcion, ruta_imagen, precio, ordenamiento1, ordenamiento2 FROM articulos WHERE precio > 0 ORDER BY id DESC");
$stmt_productos->execute();
$articulos = $stmt_productos->fetchAll(PDO::FETCH_ASSOC);

$database->closeConnection();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos los Productos | Tienda</title>

    <!-- CSS del Template -->
    <link rel="stylesheet" href="./../../dist/assets/css/theme.min.css">
    <link href="./../../dist/assets/libs/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link href="./../../dist/assets/libs/feather-webfont/dist/feather-icons.css" rel="stylesheet" />
    <link href="./../../dist/assets/libs/simplebar/dist/simplebar.min.css" rel="stylesheet" />
</head>

<body>

 

    <main>
        <div class="mt-4">
            <div class="container">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../../index.php">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Todos los Productos</li>
                    </ol>
                </nav>

                <div class="row">
                    <!-- Filtros -->
                    <div class="col-lg-3">
                        <div class="card p-3">
                            <h5 class="mb-3">Filtrar por Grupo</h5>
                            <select id="filtroGrupo" class="form-control">
                                <option value="">Todos</option>
                                <?php foreach ($grupos as $grupo): ?>
                                    <option value="<?= htmlspecialchars($grupo['ordenamiento1']); ?>">
                                        <?= htmlspecialchars($grupo['ordenamiento1']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <h5 class="mt-4 mb-3">Filtrar por Subgrupo</h5>
                            <select id="filtroSubgrupo" class="form-control">
                                <option value="">Todos</option>
                                <?php foreach ($subgrupos as $subgrupo): ?>
                                    <option value="<?= htmlspecialchars($subgrupo['ordenamiento2']); ?>">
                                        <?= htmlspecialchars($subgrupo['ordenamiento2']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <h5 class="mt-4 mb-3">Filtrar por Precio</h5>
                            <input type="range" id="filtroPrecio" class="form-range" min="0" max="100000" step="500" value="100000">
                            <p>Hasta: <span id="precioSeleccionado">100000</span></p>
                        </div>
                    </div>

                    <!-- Productos -->
                    <div class="col-lg-9">
                        <div class="row g-4 row-cols-xl-5 row-cols-lg-3 row-cols-md-2 row-cols-2 mt-2" id="productosLista">
                            <?php foreach ($articulos as $articulo): ?>
                                <div class="col producto-item" 
                                     data-grupo="<?= htmlspecialchars($articulo['ordenamiento1']); ?>" 
                                     data-subgrupo="<?= htmlspecialchars($articulo['ordenamiento2']); ?>" 
                                     data-precio="<?= $articulo['precio']; ?>">
                                    
                                    <div class="card card-product">
                                        <div class="card-body">
                                            <div class="text-center position-relative">
                                                <a href="ver_articulo.php?id=<?= $articulo['id']; ?>">
                                                    <img src="../../<?= !empty($articulo['ruta_imagen']) ? $articulo['ruta_imagen'] : 'assets/imagenes/articulos/default.png'; ?>" 
                                                        alt="<?= htmlspecialchars($articulo['descripcion']); ?>" 
                                                        class="mb-3 img-fluid" 
                                                        style="height: 200px; object-fit: cover;">
                                                </a>
                                            </div>

                                            <h2 class="fs-6">
                                                <a href="ver_articulo.php?id=<?= $articulo['id']; ?>" class="text-inherit text-decoration-none">
                                                    <?= htmlspecialchars($articulo['descripcion']); ?>
                                                </a>
                                            </h2>

                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <div>
                                                    <span class="text-dark fs-5 fw-bold">$<?= number_format($articulo['precio'], 2, ',', '.'); ?></span>
                                                </div>

                                                <div>
    <button class="btn btn-primary btn-sm agregar-carrito" data-id="<?= $articulo['id']; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        Agregar
    </button>
</div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <?php if (empty($articulos)): ?>
                                <div class="col-12 text-center">
                                    <p>No hay productos disponibles.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

  


    <!-- JS del Template -->
    <script src="./../../dist/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./../../dist/assets/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="./../../dist/assets/js/theme.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const filtroGrupo = document.getElementById("filtroGrupo");
            const filtroSubgrupo = document.getElementById("filtroSubgrupo");
            const filtroPrecio = document.getElementById("filtroPrecio");
            const precioSeleccionado = document.getElementById("precioSeleccionado");
            const productosLista = document.getElementById("productosLista");

            filtroPrecio.addEventListener("input", function () {
                precioSeleccionado.textContent = this.value;
                filtrarProductos();
            });

            filtroGrupo.addEventListener("change", filtrarProductos);
            filtroSubgrupo.addEventListener("change", filtrarProductos);

            function filtrarProductos() {
                const grupoSeleccionado = filtroGrupo.value.toLowerCase();
                const subgrupoSeleccionado = filtroSubgrupo.value.toLowerCase();
                const precioMaximo = parseFloat(filtroPrecio.value);

                document.querySelectorAll(".producto-item").forEach(producto => {
                    const grupoProducto = producto.getAttribute("data-grupo") ? producto.getAttribute("data-grupo").toLowerCase() : "";
                    const subgrupoProducto = producto.getAttribute("data-subgrupo") ? producto.getAttribute("data-subgrupo").toLowerCase() : "";
                    const precioProducto = parseFloat(producto.getAttribute("data-precio"));

                    if ((grupoSeleccionado === "" || grupoProducto.includes(grupoSeleccionado)) &&
                        (subgrupoSeleccionado === "" || subgrupoProducto.includes(subgrupoSeleccionado)) &&
                        (precioProducto <= precioMaximo)) {
                        producto.style.display = "block";
                    } else {
                        producto.style.display = "none";
                    }
                });
            }
        });
    </script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const botonesAgregar = document.querySelectorAll(".agregar-carrito");

    botonesAgregar.forEach(boton => {
        boton.addEventListener("click", function () {
            const idArticulo = this.getAttribute("data-id");

            fetch("../../backend/controllers/carrito/carrito_controller.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `accion=agregar&idArticulo=${idArticulo}&cantidad=1`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("✅ Artículo agregado al carrito.");
                } else {
                    alert("⚠️ Error: " + data.error);
                }
            })
            .catch(error => console.error("Error:", error));
        });
    });
});
</script>

</body>
</html>
