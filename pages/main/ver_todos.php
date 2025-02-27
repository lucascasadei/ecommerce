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
    <style>
    /* Asegurar que los filtros no afecten el ancho de la cuadrícula */
    @media (min-width: 992px) {
        .col-lg-3 {
            max-width: 25%;
        }

        .col-lg-9 {
            max-width: 75%;
        }
    }

    /* Asegurar que los productos se ajusten correctamente */
    #productosLista {
        display: flex;
        flex-wrap: wrap;
    }
    </style>
</head>

<body>


    <main>
        <!-- navigation -->
        <?php include '../header/header.php'; ?>
        <div class="container">

            <div class="row">
                <!-- Filtros -->
                <div class="col-lg-3 col-md-4">
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
                        <input type="range" id="filtroPrecio" class="form-range" min="0" max="100000" step="500"
                            value="100000">
                        <p>Hasta: <span id="precioSeleccionado">100000</span></p>

                        <div class="d-flex justify-content-center mt-3">
                            <a href="../carrito/carrito.php" class="btn btn-primary">🛒 Ver Carrito</a>
                        </div>
                    </div>
                </div>

                <!-- Productos -->
                <div class="col-lg-9 col-md-8">
                    <div class="row justify-content-center mb-4">
                        <div class="col-xxl-12 col-xl-8 col-lg-6 col-md-9">
                            <form action="#" method="GET">
                                <div class="input-group">
                                    <input class="form-control" type="search" placeholder="Buscar productos"
                                        aria-label="Buscar productos" aria-describedby="button-addon2"
                                        id="buscarProductos">
                                    <button class="btn btn-primary" type="button" id="button-addon2">Buscar</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Controles de vista y cantidad -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <button class="btn btn-outline-secondary me-2 view-toggle" data-view="list">
                                <i class="bi bi-list-ul"></i>
                            </button>
                            <button class="btn btn-outline-secondary me-2 view-toggle " data-view="grid">
                                <i class="bi bi-grid"></i>
                            </button>
                            <button class="btn btn-outline-secondary view-toggle active" data-view="grid-3">
                                <i class="bi bi-grid-3x3-gap"></i>
                            </button>
                        </div>
                        <div class="d-flex">
                            <select id="cantidadProductos" class="form-select me-2">
                                <option value="10">Mostrar: 10</option>
                                <option value="20">Mostrar: 20</option>
                                <option value="30">Mostrar: 30</option>
                                <option value="50">Mostrar: 50</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 row-cols-1 row-cols-md-2 row-cols-lg-3" id="productosLista">

                        <?php foreach ($articulos as $articulo): ?>
                        <div class="col producto-item" data-grupo="<?= htmlspecialchars($articulo['ordenamiento1']); ?>"
                            data-subgrupo="<?= htmlspecialchars($articulo['ordenamiento2']); ?>"
                            data-precio="<?= $articulo['precio']; ?>">

                            <div class="card card-product h-100">
                                <div class="card-body">
                                    <div class="text-center position-relative">
                                        <a href="ver_articulo.php?id=<?= $articulo['id']; ?>">
                                            <img src="../../<?= !empty($articulo['ruta_imagen']) ? $articulo['ruta_imagen'] : 'assets/imagenes/articulos/default.png'; ?>"
                                                alt="<?= htmlspecialchars($articulo['descripcion']); ?>"
                                                class="mb-3 img-fluid" style="height: 200px; object-fit: cover;">
                                        </a>
                                    </div>

                                    <h2 class="fs-6">
                                        <a href="ver_articulo.php?id=<?= $articulo['id']; ?>"
                                            class="text-inherit text-decoration-none">
                                            <?= htmlspecialchars($articulo['descripcion']); ?>
                                        </a>
                                    </h2>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div>
                                            <span
                                                class="text-dark fs-5 fw-bold">$<?= number_format($articulo['precio'], 2, ',', '.'); ?></span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-outline-primary btn-sm btn-disminuir"
                                                data-id="<?= $articulo['id']; ?>">-</button>
                                            <span class="mx-2 cantidad-producto"
                                                data-id="<?= $articulo['id']; ?>">0</span>
                                            <button class="btn btn-outline-primary btn-sm btn-aumentar"
                                                data-id="<?= $articulo['id']; ?>">+</button>
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

                    <!-- Paginación -->
                    <nav class="mt-4">
                        <ul class="pagination justify-content-center" id="paginacion"></ul>
                    </nav>
                </div>
            </div>
        </div>

    </main>




    <!-- JS del Template -->
    <script src="./../../dist/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./../../dist/assets/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="./../../dist/assets/js/theme.min.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
       ;
        const botonesVista = document.querySelectorAll(".view-toggle");
        const inputBuscar = document.getElementById("buscarProductos");
    const productosLista = document.getElementById("productosLista");
    const productos = document.querySelectorAll(".producto-item"); // Selecciona todos los productos ya cargados

    function buscarProductos() {
        let terminoBusqueda = inputBuscar.value.trim().toLowerCase();

        // Si el input está vacío, mostrar todos los productos y salir
        if (terminoBusqueda === "") {
            productos.forEach(producto => producto.style.display = "block");
            return;
        }

        // Filtrar productos según la descripción
        productos.forEach(producto => {
            let descripcion = producto.querySelector("h2 a").innerText.toLowerCase();
            if (descripcion.includes(terminoBusqueda)) {
                producto.style.display = "block"; // Mostrar si coincide
            } else {
                producto.style.display = "none"; // Ocultar si no coincide
            }
        });
    }

    // Escuchar evento de entrada en el campo de búsqueda
    inputBuscar.addEventListener("input", buscarProductos);

        // Evento para búsqueda dinámica
        inputBuscar.addEventListener("input", buscarProductos);
        // Función para cambiar la vista
        function cambiarVista(vista) {
            // Elimina TODAS las clases de columnas
            productosLista.classList.remove(
                "row-cols-1",
                "row-cols-2",
                "row-cols-3",
                "row-cols-4",
                "row-cols-5",
                "row-cols-md-2",
                "row-cols-md-3",
                "row-cols-lg-3",
                "row-cols-lg-4",
                "row-cols-xl-5",
                "row-cols-sm-1",
                "row-cols-sm-2",
                "row-cols-sm-3",
            )

            // Aplica la vista seleccionada
            if (vista === "list") {
                productosLista.classList.add("row-cols-1")
            } else if (vista === "grid") {
                productosLista.classList.add("row-cols-1", "row-cols-sm-2", "row-cols-md-2")
            } else if (vista === "grid-3") {
                productosLista.classList.add("row-cols-1", "row-cols-sm-2", "row-cols-md-2", "row-cols-lg-3")
            }
        }

        // Aplicar vista predeterminada (3 columnas)
        cambiarVista("grid-3");

        // Evento para los botones de vista
        botonesVista.forEach(boton => {
            boton.addEventListener("click", function() {
                // Remover la clase 'active' de todos los botones y asignarla al botón seleccionado
                botonesVista.forEach(b => b.classList.remove("active"));
                this.classList.add("active");

                // Obtener la vista seleccionada y aplicarla
                const vistaSeleccionada = this.dataset.view;
                cambiarVista(vistaSeleccionada);
            });
        });


        // Función para filtrar productos dinámicamente
        function filtrarProductos() {
            const grupoSeleccionado = filtroGrupo.value.toLowerCase();
            const subgrupoSeleccionado = filtroSubgrupo.value.toLowerCase();
            const precioMaximo = parseFloat(filtroPrecio.value);

            document.querySelectorAll(".producto-item").forEach(producto => {
                const grupoProducto = producto.getAttribute("data-grupo") ? producto.getAttribute(
                    "data-grupo").toLowerCase() : "";
                const subgrupoProducto = producto.getAttribute("data-subgrupo") ? producto.getAttribute(
                    "data-subgrupo").toLowerCase() : "";
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

        // Eventos para los filtros
        filtroPrecio.addEventListener("input", function() {
            precioSeleccionado.textContent = this.value;
            filtrarProductos();
        });

        filtroGrupo.addEventListener("change", filtrarProductos);
        filtroSubgrupo.addEventListener("change", filtrarProductos);

        // 🛒 Funcionalidad del carrito
        function inicializarCarrito() {
            fetch("../../backend/controllers/carrito/carrito_controller.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "accion=obtener"
                })
                .then(response => response.json())
                .then(data => {
                    if (Array.isArray(data)) {
                        data.forEach(item => {
                            const cantidadElemento = document.querySelector(
                                `.cantidad-producto[data-id="${item.idArticulo}"]`);
                            if (cantidadElemento) {
                                cantidadElemento.textContent = item.cantidad;
                                mostrarControles(item.idArticulo, item.cantidad);
                            }
                        });
                    }
                })
                .catch(error => console.error("Error obteniendo carrito:", error));
        }

        // 🛒 Evento para agregar un producto al carrito
        document.querySelectorAll(".btn-agregar").forEach(boton => {
            boton.addEventListener("click", function() {
                const idArticulo = this.getAttribute("data-id");
                const parentDiv = this.parentElement;

                fetch("../../backend/controllers/carrito/carrito_controller.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: `accion=agregar&idArticulo=${idArticulo}&cantidad=1`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            mostrarControles(idArticulo, 1);
                        } else {
                            alert("⚠️ Error: " + data.error);
                        }
                    })
                    .catch(error => console.error("Error:", error));
            });
        });

        // 🛒 Función para mostrar los botones "-" y "+" después de agregar un producto
        function mostrarControles(idArticulo, cantidad) {
            const parentDiv = document.querySelector(`.btn-agregar[data-id="${idArticulo}"]`)?.parentElement;
            if (parentDiv) {
                parentDiv.innerHTML = `
                <button class="btn btn-outline-primary btn-sm btn-disminuir" data-id="${idArticulo}">-</button>
                <span class="mx-2 cantidad-producto" data-id="${idArticulo}">${cantidad}</span>
                <button class="btn btn-outline-primary btn-sm btn-aumentar" data-id="${idArticulo}">+</button>
            `;
                agregarEventosCantidad();
            }
        }

        // 🛒 Función para manejar eventos de incremento y decremento
        function agregarEventosCantidad() {
            document.querySelectorAll(".btn-aumentar").forEach(boton => {
                boton.addEventListener("click", function() {
                    const idArticulo = this.getAttribute("data-id");
                    const cantidadElemento = document.querySelector(
                        `.cantidad-producto[data-id="${idArticulo}"]`);
                    let cantidadActual = parseInt(cantidadElemento.textContent, 10) || 0;
                    let nuevaCantidad = cantidadActual + 1;

                    // Verificar si el producto ya está en el carrito
                    fetch("../../backend/controllers/carrito/carrito_controller.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },
                            body: `accion=obtener`
                        })
                        .then(response => response.json())
                        .then(data => {
                            let enCarrito = data.some(item => item.idArticulo ==
                                idArticulo);
                            let accion = enCarrito ? "actualizar" : "agregar";

                            fetch("../../backend/controllers/carrito/carrito_controller.php", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/x-www-form-urlencoded"
                                    },
                                    body: `accion=${accion}&idArticulo=${idArticulo}&cantidad=${nuevaCantidad}`
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        cantidadElemento.textContent = nuevaCantidad;
                                    } else {
                                        alert("⚠️ Error: " + data.error);
                                    }
                                })
                                .catch(error => console.error("Error:", error));
                        });
                });
            });
            document.querySelectorAll(".btn-disminuir").forEach(boton => {
                boton.addEventListener("click", function() {
                    const idArticulo = this.getAttribute("data-id");
                    const cantidadElemento = document.querySelector(
                        `.cantidad-producto[data-id="${idArticulo}"]`);
                    let cantidadActual = parseInt(cantidadElemento.textContent, 10) || 0;

                    if (cantidadActual > 1) {
                        let nuevaCantidad = cantidadActual - 1;

                        fetch("../../backend/controllers/carrito/carrito_controller.php", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/x-www-form-urlencoded"
                                },
                                body: `accion=actualizar&idArticulo=${idArticulo}&cantidad=${nuevaCantidad}`
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    cantidadElemento.textContent = nuevaCantidad;
                                } else {
                                    alert("⚠️ Error: " + data.error);
                                }
                            })
                            .catch(error => console.error("Error:", error));
                    } else {
                        // Cuando la cantidad llega a 0, eliminar el producto del carrito
                        fetch("../../backend/controllers/carrito/carrito_controller.php", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/x-www-form-urlencoded"
                                },
                                body: `accion=eliminar&idArticulo=${idArticulo}`
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Reemplazar los controles con el botón "+"
                                    const parentDiv = cantidadElemento.parentElement;
                                    parentDiv.innerHTML =
                                        `<button class="btn btn-primary btn-sm btn-agregar" data-id="${idArticulo}">+</button>`;

                                    // Volver a asignar eventos al nuevo botón
                                    document.querySelector(
                                            `.btn-agregar[data-id="${idArticulo}"]`)
                                        .addEventListener("click", function() {
                                            agregarProductoAlCarrito(idArticulo);
                                        });
                                } else {
                                    alert("⚠️ Error: " + data.error);
                                }
                            })
                            .catch(error => console.error("Error:", error));
                    }
                });
            });

            // Nueva función para agregar un producto al carrito
            function agregarProductoAlCarrito(idArticulo) {
                fetch("../../backend/controllers/carrito/carrito_controller.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: `accion=agregar&idArticulo=${idArticulo}&cantidad=1`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            mostrarControles(idArticulo, 1);
                        } else {
                            alert("⚠️ Error: " + data.error);
                        }
                    })
                    .catch(error => console.error("Error:", error));
            }

        }

        inicializarCarrito();
        agregarEventosCantidad();
    });
    </script>


</body>

</html>