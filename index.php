<?php
session_start();

// Si el usuario tiene sesión activa, lo redirige a main.php
if (isset($_SESSION['usuario'])) {
    header("Location: pages/main/main.php");
    exit;
}


require_once './backend/database/Database.php';

$database = new Database();
$pdo = $database->getConnection();

// Obtener los productos con precio mayor a 0 desde la base de datos con su imagen
$stmt = $pdo->prepare("
    SELECT a.id, a.codigo_generico, a.descripcion, a.precio,
           COALESCE(i.ruta_imagen, 'assets/imagenes/articulos/default.png') AS ruta_imagen
    FROM articulos a
    LEFT JOIN imagenes_articulos i ON a.codigo_generico = i.codigo_generico
    WHERE a.precio > 0 
    ORDER BY a.id DESC 
    LIMIT 8
");
$stmt->execute();

$articulos = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Obtener productos en oferta (precio_actual < precio_original y código empieza con "KIT")
// Obtener productos cuyo codigo_generico empieza con 'KIT' y el precio sea mayor a 0
$stmt_ofertas = $pdo->prepare("
    SELECT a.id, a.codigo_generico, a.descripcion, a.precio, a.ordenamiento1, a.ordenamiento2,
           COALESCE(i.ruta_imagen, 'assets/imagenes/articulos/default.png') AS ruta_imagen
    FROM articulos a
    LEFT JOIN imagenes_articulos i ON a.codigo_generico = i.codigo_generico
    WHERE a.codigo_generico LIKE 'KIT%' 
    AND a.precio > 0
");
$stmt_ofertas->execute();

$ofertas = $stmt_ofertas->fetchAll(PDO::FETCH_ASSOC);



$database->closeConnection();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta content="Codescandy" name="author" />
    <title>
        Homepage v5 - Modern Design eCommerce HTML Template - FreshCart
    </title>
    <link href="dist/assets/libs/tiny-slider/dist/tiny-slider.css" rel="stylesheet" />
    <link href="dist/assets/libs/slick-carousel/slick/slick.css" rel="stylesheet" />
    <link href="dist/assets/libs/slick-carousel/slick/slick-theme.css" rel="stylesheet" />
    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/x-icon" href="dist/assets/images/favicon/favicon.ico" />

    <!-- Libs CSS -->
    <link href="dist/assets/libs/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link href="dist/assets/libs/feather-webfont/dist/feather-icons.css" rel="stylesheet" />
    <link href="dist/assets/libs/simplebar/dist/simplebar.min.css" rel="stylesheet" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="dist/assets/css/theme.min.css" />
</head>

<body>
    <!-- navigation -->
    <?php include './pages/header/header.php'; ?>


    <nav class="navbar navbar-expand-lg navbar-light navbar-default p-0 p-sm-0 navbar-offcanvas-color"
        aria-label="Offcanvas navbar large">
        <div class="container">
            <div class="offcanvas offcanvas-start" tabindex="-1" id="navbar-default"
                aria-labelledby="navbar-defaultLabel">
                <div class="offcanvas-header pb-1">
                    <a href="./index.html">
                        <img src="dist/assets/images/logo/logo.png" alt="Logo eCommerce de Comestibles" width="50px" />
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
                </div>

            </div>
        </div>
    </nav>

    <!-- Shop Cart -->

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header border-bottom">
            <div class="text-start">
                <h5 id="offcanvasRightLabel" class="mb-0 fs-4">Shop Cart</h5>
                <small>Location in 382480</small>
            </div>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>
                <!-- alert -->
                <div class="alert alert-danger p-2" role="alert">
                    You’ve got FREE delivery. Start
                    <a href="#!" class="alert-link">checkout now!</a>
                </div>
                <ul class="list-group list-group-flush">
                    <!-- list group -->
                    <li class="list-group-item py-3 ps-0 border-top">
                        <!-- row -->
                        <div class="row align-items-center">
                            <div class="col-6 col-md-6 col-lg-7">
                                <div class="d-flex">
                                    <img src="dist/assets/images/products/product-img-1.jpg" alt="Ecommerce"
                                        class="icon-shape icon-xxl" />
                                    <div class="ms-3">
                                        <!-- title -->
                                        <a href="dist/pages/shop-single.html" class="text-inherit">
                                            <h6 class="mb-0">Haldiram's Sev Bhujia</h6>
                                        </a>
                                        <span><small class="text-muted">.98 / lb</small></span>
                                        <!-- text -->
                                        <div class="mt-2 small lh-1">
                                            <a href="#!" class="text-decoration-none text-inherit">
                                                <span class="me-1 align-text-bottom">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-trash-2 text-success">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path
                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                        </path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg>
                                                </span>
                                                <span class="text-muted">Remove</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- input group -->
                            <div class="col-4 col-md-3 col-lg-3">
                                <!-- input -->
                                <!-- input -->
                                <div class="input-group input-spinner">
                                    <input type="button" value="-" class="button-minus btn btn-sm"
                                        data-field="quantity" />
                                    <input type="number" step="1" max="10" value="1" name="quantity"
                                        class="quantity-field form-control-sm form-input" />
                                    <input type="button" value="+" class="button-plus btn btn-sm"
                                        data-field="quantity" />
                                </div>
                            </div>
                            <!-- price -->
                            <div class="col-2 text-lg-end text-start text-md-end col-md-2">
                                <span class="fw-bold">$5.00</span>
                            </div>
                        </div>
                    </li>
                    <!-- list group -->
                    <li class="list-group-item py-3 ps-0">
                        <!-- row -->
                        <div class="row align-items-center">
                            <div class="col-6 col-md-6 col-lg-7">
                                <div class="d-flex">
                                    <img src="dist/assets/images/products/product-img-2.jpg" alt="Ecommerce"
                                        class="icon-shape icon-xxl" />
                                    <div class="ms-3">
                                        <a href="dist/pages/shop-single.html" class="text-inherit">
                                            <h6 class="mb-0">NutriChoice Digestive</h6>
                                        </a>
                                        <span><small class="text-muted">250g</small></span>
                                        <!-- text -->
                                        <div class="mt-2 small lh-1">
                                            <a href="#!" class="text-decoration-none text-inherit">
                                                <span class="me-1 align-text-bottom">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-trash-2 text-success">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path
                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                        </path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg>
                                                </span>
                                                <span class="text-muted">Remove</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- input group -->
                            <div class="col-4 col-md-3 col-lg-3">
                                <!-- input -->
                                <!-- input -->
                                <div class="input-group input-spinner">
                                    <input type="button" value="-" class="button-minus btn btn-sm"
                                        data-field="quantity" />
                                    <input type="number" step="1" max="10" value="1" name="quantity"
                                        class="quantity-field form-control-sm form-input" />
                                    <input type="button" value="+" class="button-plus btn btn-sm"
                                        data-field="quantity" />
                                </div>
                            </div>
                            <!-- price -->
                            <div class="col-2 text-lg-end text-start text-md-end col-md-2">
                                <span class="fw-bold text-danger">$20.00</span>
                                <div class="text-decoration-line-through text-muted small">
                                    $26.00
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- list group -->
                    <li class="list-group-item py-3 ps-0">
                        <!-- row -->
                        <div class="row align-items-center">
                            <div class="col-6 col-md-6 col-lg-7">
                                <div class="d-flex">
                                    <img src="dist/assets/images/products/product-img-3.jpg" alt="Ecommerce"
                                        class="icon-shape icon-xxl" />
                                    <div class="ms-3">
                                        <!-- title -->
                                        <a href="dist/pages/shop-single.html" class="text-inherit">
                                            <h6 class="mb-0">Cadbury 5 Star Chocolate</h6>
                                        </a>
                                        <span><small class="text-muted">1 kg</small></span>
                                        <!-- text -->
                                        <div class="mt-2 small lh-1">
                                            <a href="#!" class="text-decoration-none text-inherit">
                                                <span class="me-1 align-text-bottom">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-trash-2 text-success">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path
                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                        </path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg>
                                                </span>
                                                <span class="text-muted">Remove</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- input group -->
                            <div class="col-4 col-md-3 col-lg-3">
                                <!-- input -->
                                <!-- input -->
                                <div class="input-group input-spinner">
                                    <input type="button" value="-" class="button-minus btn btn-sm"
                                        data-field="quantity" />
                                    <input type="number" step="1" max="10" value="1" name="quantity"
                                        class="quantity-field form-control-sm form-input" />
                                    <input type="button" value="+" class="button-plus btn btn-sm"
                                        data-field="quantity" />
                                </div>
                            </div>
                            <!-- price -->
                            <div class="col-2 text-lg-end text-start text-md-end col-md-2">
                                <span class="fw-bold">$15.00</span>
                                <div class="text-decoration-line-through text-muted small">
                                    $20.00
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- list group -->
                    <li class="list-group-item py-3 ps-0">
                        <!-- row -->
                        <div class="row align-items-center">
                            <div class="col-6 col-md-6 col-lg-7">
                                <div class="d-flex">
                                    <img src="dist/assets/images/products/product-img-4.jpg" alt="Ecommerce"
                                        class="icon-shape icon-xxl" />
                                    <div class="ms-3">
                                        <!-- title -->
                                        <!-- title -->
                                        <a href="dist/pages/shop-single.html" class="text-inherit">
                                            <h6 class="mb-0">Onion Flavour Potato</h6>
                                        </a>
                                        <span><small class="text-muted">250g</small></span>
                                        <!-- text -->
                                        <div class="mt-2 small lh-1">
                                            <a href="#!" class="text-decoration-none text-inherit">
                                                <span class="me-1 align-text-bottom">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-trash-2 text-success">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path
                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                        </path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg>
                                                </span>
                                                <span class="text-muted">Remove</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- input group -->
                            <div class="col-4 col-md-3 col-lg-3">
                                <!-- input -->
                                <!-- input -->
                                <div class="input-group input-spinner">
                                    <input type="button" value="-" class="button-minus btn btn-sm"
                                        data-field="quantity" />
                                    <input type="number" step="1" max="10" value="1" name="quantity"
                                        class="quantity-field form-control-sm form-input" />
                                    <input type="button" value="+" class="button-plus btn btn-sm"
                                        data-field="quantity" />
                                </div>
                            </div>
                            <!-- price -->
                            <div class="col-2 text-lg-end text-start text-md-end col-md-2">
                                <span class="fw-bold">$15.00</span>
                                <div class="text-decoration-line-through text-muted small">
                                    $20.00
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- list group -->
                    <li class="list-group-item py-3 ps-0 border-bottom">
                        <!-- row -->
                        <div class="row align-items-center">
                            <div class="col-6 col-md-6 col-lg-7">
                                <div class="d-flex">
                                    <img src="dist/assets/images/products/product-img-5.jpg" alt="Ecommerce"
                                        class="icon-shape icon-xxl" />
                                    <div class="ms-3">
                                        <!-- title -->
                                        <a href="dist/pages/shop-single.html" class="text-inherit">
                                            <h6 class="mb-0">Salted Instant Popcorn</h6>
                                        </a>
                                        <span><small class="text-muted">100g</small></span>
                                        <!-- text -->
                                        <div class="mt-2 small lh-1">
                                            <a href="#!" class="text-decoration-none text-inherit">
                                                <span class="me-1 align-text-bottom">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-trash-2 text-success">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path
                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                        </path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg>
                                                </span>
                                                <span class="text-muted">Remove</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- input group -->
                            <div class="col-4 col-md-3 col-lg-3">
                                <!-- input -->
                                <!-- input -->
                                <div class="input-group input-spinner">
                                    <input type="button" value="-" class="button-minus btn btn-sm"
                                        data-field="quantity" />
                                    <input type="number" step="1" max="10" value="1" name="quantity"
                                        class="quantity-field form-control-sm form-input" />
                                    <input type="button" value="+" class="button-plus btn btn-sm"
                                        data-field="quantity" />
                                </div>
                            </div>
                            <!-- price -->
                            <div class="col-2 text-lg-end text-start text-md-end col-md-2">
                                <span class="fw-bold">$15.00</span>
                                <div class="text-decoration-line-through text-muted small">
                                    $25.00
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <!-- btn -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="#!" class="btn btn-primary">Continue Shopping</a>
                    <a href="#!" class="btn btn-dark">Update Cart</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <div class="modal-header border-0">
                    <h5 class="modal-title fs-3 fw-bold" id="loginModalLabel">
                        Sign In
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm">
                        <!-- Eliminamos action y method -->
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="usuario" name="usuario"
                                placeholder="Ingrese su usuario" required />
                        </div>

                        <div class="mb-4">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena"
                                placeholder="Ingrese su contraseña" required />
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                    </form>
                </div>
            </div>
        </div>




    </div>

    <div class="bg-white position-fixed bottom-0 w-100 z-1 shadow-lg d-block d-lg-none text-center">
        <div class="d-flex align-items-center">
            <div class="w-25 icon-hover py-4">
                <!-- Button -->
                <button class="navbar-toggler collapsed d-lg-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                        class="bi bi-text-indent-left text-primary" viewBox="0 0 16 16">
                        <path
                            d="M2 3.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm.646 2.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L4.293 8 2.646 6.354a.5.5 0 0 1 0-.708zM7 6.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                    </svg>
                </button>
            </div>

            <div class="dropdown w-25 ms-2 py-4 icon-hover">
                <a href="#" class="text-inherit" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="text-center">
                        <div class="position-relative d-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                class="bi bi-bell" viewBox="0 0 16 16">
                                <path
                                    d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
                            </svg>
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                1
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </div>
                    </div>
                </a>

                <div class="dropdown-menu dropdown-menu-lg p-0">
                    <div>
                        <h6 class="px-4 border-bottom py-3 mb-0">Notification</h6>
                        <p class="mb-0 px-4 py-3">
                            <a href="dist/pages/signin.html">Sign in</a>
                            or
                            <a href="dist/pages/signup.html">Register</a>
                            in or so you don t have to enter your details every time
                        </p>
                    </div>
                </div>
            </div>

            <div class="w-25 ms-2 py-4 icon-hover">
                <a href="javascript:void(0)" class="text-inherit" data-bs-toggle="modal" data-bs-target="#userModal">
                    <div class="text-center">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                <path fill-rule="evenodd"
                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
            <div class="w-25 ms-2 py-4 icon-hover">
                <a href="dist/pages/account-orders.html" class="text-inherit">
                    <div class="text-center">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                class="bi bi-archive" viewBox="0 0 16 16">
                                <path
                                    d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
            <div class="w-25 ms-2 py-4 icon-hover">
                <a data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" href="#offcanvasExample" role="button"
                    aria-controls="offcanvasRight" class="text-inherit">
                    <div class="text-center">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                class="bi bi-cart2" viewBox="0 0 16 16">
                                <path
                                    d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z" />
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
            <div class="w-25 ms-2 py-4 icon-hover">
                <a class="text-inherit" data-bs-toggle="offcanvas" href="#offcanvasCategory" role="button"
                    aria-controls="offcanvasCategory">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        class="bi bi-funnel" viewBox="0 0 16 16">
                        <path
                            d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <main>
        <section class="mt-8">
            <div class="container">
                <div class="hero-slider">
                    <div style="
                background: url(dist/assets/images/slider/hero-img-slider-1.jpg)
                  no-repeat;
                background-size: cover;
                border-radius: 0.5rem;
                background-position: center;
              ">
                        <div class="ps-lg-12 py-lg-16 col-xxl-5 col-lg-7 col-md-8 py-14 px-8 text-xs-center">
                            <h1 class="text-white display-5 fw-bold mt-4">
                                SuperMarket For Fresh Grocery
                            </h1>
                            <p class="lead text-white">
                                Introduced a new model for online grocery shopping and
                                convenient home delivery at any time.
                            </p>
                            <a href="#!" class="btn btn-dark mt-3">
                                Shop Now
                                <i class="feather-icon icon-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <div style="
                background: url(dist/assets/images/slider/hero-img-slider-2.jpg)
                  no-repeat;
                background-size: cover;
                border-radius: 0.5rem;
                background-position: center;
              ">
                        <div class="ps-lg-12 py-lg-16 col-xxl-5 col-lg-7 col-md-8 py-14 px-8 text-xs-center">
                            <h1 class="text-dark display-5 fw-bold mt-4">
                                Opening Sale
                                <br />
                                Discount up to
                                <span class="text-primary display-6">50%</span>
                            </h1>
                            <p class="lead">
                                Snack on late-night munchies of delicious nuts & you’re
                                guaranteed happiness before you doze!
                            </p>
                            <a href="#!" class="btn btn-dark mt-3">
                                Shop Now
                                <i class="feather-icon icon-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <div style="
                background: url(dist/assets/images/slider/hero-img-slider-3.jpg)
                  no-repeat;
                background-size: cover;
                border-radius: 0.5rem;
                background-position: center;
              ">
                        <div class="ps-lg-12 py-lg-16 col-xxl-5 col-lg-7 col-md-8 py-14 px-8 text-xs-center">
                            <h1 class="text-dark display-5 fw-bold mt-4">
                                Midnight Munch Combo
                            </h1>
                            <p class="lead">
                                Snack on late-night munchies of delicious nuts & you’re
                                guaranteed happiness before you doze!
                            </p>
                            <a href="#!" class="btn btn-dark mt-3">
                                Shop Now
                                <i class="feather-icon icon-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="mt-lg-12 mb-lg-14 mb-8">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- col -->
                    <aside class="col-xl-3 col-lg-4 col-md-4 mb-6 mb-md-0">
                        <div id="sidebar">
                            <div class="sidebar__inner">
                                <div class="offcanvas offcanvas-start offcanvas-collapse" tabindex="-1"
                                    id="offcanvasCategory" aria-labelledby="offcanvasCategoryLabel">
                                    <div class="offcanvas-header d-lg-none">
                                        <h5 class="offcanvas-title" id="offcanvasCategoryLabel">
                                            Filter
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body p-lg-0">
                                        <div class="mb-4">
                                            <!-- title -->
                                            <h3 class="mb-4 h5">Proveedores</h3>
                                            <!-- nav -->
                                            <div class="card">
                                                <ul class="nav nav-category" id="categoryCollapseMenu">
                                                    <!-- lacteos -->
                                                    <li class="nav-item border-bottom w-100 collapsed px-4 py-1">
                                                        <a href="javascript:void(0)" class="nav-link"
                                                            data-bs-toggle="collapse" data-bs-target="#categoryFlushOne"
                                                            aria-expanded="false" aria-controls="categoryFlushOne">
                                                            <span class="d-flex align-items-center">
                                                                <!-- Reemplazamos el SVG por una imagen -->
                                                                <img src="./dist/assets/images/logo/milkaut.png"
                                                                    width="24" height="24" alt="Lácteos y Derivados">

                                                                <span class="ms-2">Milkaut</span>
                                                            </span>
                                                            <i class="feather-icon icon-chevron-right"></i>
                                                        </a>

                                                        <!-- accordion collapse -->
                                                        <div id="categoryFlushOne" class="accordion-collapse collapse"
                                                            data-bs-parent="#categoryCollapseMenu">
                                                            <div>
                                                                <!-- nav -->

                                                                <ul class="nav flex-column ms-8">
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Leche</a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Crema de leche</a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Quesos</a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Yogurt</a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Manteca</a>
                                                                    </li>
                                                                    <!-- 
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Buns & Bakery</a>
                                                                    </li>
                                                                
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Butter & More</a>
                                                                    </li>
                                                                    
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Cheese</a>
                                                                    </li>
                                                                   
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Paneer & Tofu</a>
                                                                    </li>
                                                               
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Cream & Whitener</a>
                                                                    </li>
                                                                
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Condensed Milk</a>
                                                                    </li>
                                                               
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Vegan Drinks</a>
                                                                    </li>  -->
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="nav-item border-bottom w-100 collapsed px-4 py-1">
                                                        <a href="javascript:void(0)" class="nav-link"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#flush-collapseSix" aria-expanded="false"
                                                            aria-controls="flush-collapseSix">
                                                            <span class="d-flex align-items-center">
                                                                <img src="./dist/assets/images/logo/donyeyo.png"
                                                                    width="24" height="24" alt="Lácteos y Derivados">



                                                                <span class="ms-2">Don Yeyo</span>
                                                            </span>
                                                            <i class="feather-icon icon-chevron-right"></i>
                                                        </a>

                                                        <!-- collapse -->
                                                        <div id="flush-collapseSix" class="accordion-collapse collapse"
                                                            data-bs-parent="#categoryCollapseMenu">
                                                            <div>
                                                                <ul class="nav flex-column ms-8">
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a class="nav-link active" aria-current="page"
                                                                            href="javascript:void(0)">Fideos</a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Ñoquis</a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Ravioles</a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Sorrentinos</a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Pascualinas</a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Panadería</a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Capellettis</a>
                                                                    </li>
                                                                    <!-- nav item
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Buns & Bakery</a>
                                                                    </li> -->
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <li class="nav-item border-bottom w-100 collapsed px-4 py-1">
                                                        <a href="javascript:void(0)" class="nav-link"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#flush-collapseThree" aria-expanded="false"
                                                            aria-controls="flush-collapseThree">
                                                            <span class="d-flex align-items-center">
                                                                <img src="./dist/assets/images/logo/swift.jpg"
                                                                    width="24" height="24" alt="Lácteos y Derivados">

                                                                <span class="ms-2">Swift</span>
                                                            </span>
                                                            <i class="feather-icon icon-chevron-right"></i>
                                                        </a>

                                                        <!-- collapse -->
                                                        <div id="flush-collapseThree"
                                                            class="accordion-collapse collapse"
                                                            data-bs-parent="#categoryCollapseMenu">
                                                            <div>
                                                                <ul class="nav flex-column ms-8">
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a class="nav-link active" aria-current="page"
                                                                            href="javascript:void(0)">Hamburguesas</a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Salchichas</a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Fresh Fruits</a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Organic Fruits &
                                                                            Vegetables</a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Cuts & Sprouts</a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Exotic Fruits &
                                                                            Veggies</a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Flower Bouquets,
                                                                            Bunches</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <!-- snacks item -->
                                                    <li class="nav-item border-bottom w-100 collapsed px-4 py-1">
                                                        <a href="javascript:void(0)" class="nav-link"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                                            aria-controls="flush-collapseTwo">
                                                            <span class="d-flex align-items-center">
                                                                <img src="./dist/assets/images/logo/lav.png"
                                                                    width="24" height="24" alt="Lácteos y Derivados">

                                                                <span class="ms-2">La Virginia</span>
                                                            </span>
                                                            <i class="feather-icon icon-chevron-right"></i>
                                                        </a>

                                                        <!-- collapse -->
                                                        <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                                            data-bs-parent="#categoryCollapseMenu">
                                                            <div>
                                                                <ul class="nav flex-column ms-8">
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Azúcar, Sal</a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Harina</a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Yerba</a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Té/Infusión</a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Café</a>
                                                                    </li>
                                                                    <!-- 
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Healthy Snacks</a>
                                                                    </li>
                                                                
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Cakes & Rolls</a>
                                                                    </li>
                                                               
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Energy Bars</a>
                                                                    </li>
                                                                    
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Papad & Fryums</a>
                                                                    </li>
                                                                    
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Rusks & Wafers</a>
                                                                    </li>-->
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <!-- frutas vegetales item -->

                                                    <!-- bebidas jugos item -->
                                                    <li class="nav-item border-bottom w-100 collapsed px-4 py-1">
                                                        <a href="javascript:void(0)" class="nav-link"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#flush-collapseFour" aria-expanded="false"
                                                            aria-controls="flush-collapseFour">
                                                            <span class="d-flex align-items-center">
                                                            <img src="./dist/assets/images/logo/citric.png"
                                                            width="24" height="24" alt="Citric">
                                                                <span class="ms-2">Citric</span>
                                                            </span>
                                                            <i class="feather-icon icon-chevron-right"></i>
                                                        </a>

                                                        <!-- collapse -->
                                                        <div id="flush-collapseFour" class="accordion-collapse collapse"
                                                            data-bs-parent="#categoryCollapseMenu">
                                                            <div>
                                                                <ul class="nav flex-column ms-8">
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Bebida con alcohol
                                                                        </a>
                                                                    </li>
                                                                    <!-- nav item -->
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Bebida sin alcohol</a>
                                                                    </li>
                                                                    <!-- nav item 
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Coldpress</a>
                                                                    </li>
                                                                 
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Energy Drinks</a>
                                                                    </li>
                                                                  
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Water & Ice Cubes</a>
                                                                    </li>
                                                                   
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Soda & Mixers</a>
                                                                    </li>
                                                                  
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Concentrates & Syrups</a>
                                                                    </li>
                                                                  
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Detox & Energy Drinks</a>
                                                                    </li>
                                                                   
                                                                    <li class="nav-item">
                                                                        <a href="javascript:void(0)"
                                                                            class="nav-link">Juice Collection</a>
                                                                    </li>-->
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <!-- bebes  item 
                                                    <li class="nav-item border-bottom w-100 collapsed px-4 py-1">
                                                        <a href="javascript:void(0)" class="nav-link"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#flush-collapseFive" aria-expanded="false"
                                                            aria-controls="flush-collapseFive">
                                                            <span class="d-flex align-items-center">
                                                                <svg width="24" height="24" fill="#3d4f58"
                                                                    viewBox="0 0 56 56"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M6.254 1.513c-.71.273-1.49 1.063-1.759 1.781-.176.471-.202.73-.202 2.047 0 1.345.022 1.551.198 1.916.243.502.77.869 1.341.933l.421.048v1.751c0 2.174-.068 2.433-1.216 4.576-.982 1.833-1.147 2.203-1.473 3.308l-.248.84-.029 15.4c-.022 11.182-.001 15.554.076 15.96.32 1.697 1.702 3.091 3.425 3.457.53.112 2.56.134 12.579.134 7.666.001 12.164-.033 12.553-.094 1.265-.199 2.642-1.189 3.209-2.308.554-1.094.53-.279.503-17.125l-.026-15.424-.211-.746c-.12-.424-.715-1.777-1.375-3.127-.64-1.309-1.205-2.569-1.256-2.8-.051-.231-.094-1.177-.095-2.101l-.002-1.682.468-.166c.611-.217 1.068-.628 1.261-1.131.126-.33.149-.673.123-1.842-.032-1.406-.039-1.449-.34-2.06-.334-.678-.812-1.152-1.505-1.494l-.427-.211-12.74-.019-12.74-.019-.513.198M32.097 2.94c.174.103.447.348.606.545.289.357.29.364.32 1.64.025 1.033.004 1.303-.105 1.393-.104.087-3.241.113-13.604.115-12.557.003-13.474-.008-13.556-.155-.05-.088-.069-.661-.045-1.295.038-.975.076-1.194.265-1.532.235-.418.667-.74 1.149-.856.161-.039 5.774-.064 12.473-.056 11.999.014 12.185.017 12.497.201m14.01 4.864c-1.432.516-3.071 2.37-3.929 4.44-1.486 3.591-.888 8.241 1.417 11.011l.362.434-.659 13.192c-.526 10.555-.638 13.304-.559 13.752.207 1.178 1.02 2.331 2.021 2.867 2.469 1.322 5.43.03 6.055-2.641.131-.558.099-1.499-.464-13.83l-.604-13.232.565-.712c.921-1.158 1.547-2.597 1.924-4.418.228-1.099.231-3.43.007-4.357-.531-2.195-1.649-4.183-3.098-5.512-1.085-.994-2.11-1.329-3.038-.994m-14.929 2.369c.029 1.09.103 2.115.171 2.38.067.257.664 1.58 1.327 2.94.886 1.818 1.242 2.653 1.346 3.15.122.588.137 2.652.116 16.006l-.025 15.331-.319.588c-.367.678-.688.978-1.407 1.317l-.514.242H6.953l-.466-.231c-.679-.335-1.288-.982-1.529-1.626l-.201-.539.025-15.462.025-15.462.302-.887c.166-.488.674-1.584 1.129-2.437.454-.853.906-1.745 1.004-1.982l.178-.43 5.865-.026 5.865-.025.178-.22a.786.786 0 0 0-.024-1.011l-.203-.216H7.747v-3.36l11.69.023 11.69.024.051 1.913m16.334-.762c1.185.755 2.455 2.6 3.017 4.382.689 2.187.459 4.931-.593 7.067-1.056 2.142-2.596 3.023-4.066 2.325-2.184-1.036-3.55-5.39-2.779-8.858.474-2.131 1.843-4.228 3.255-4.985.481-.258.67-.247 1.166.069m-27.03 2.391c-.25.251-.285.48-.125.83.167.367.462.435 1.895.435 1.191 0 1.362-.02 1.572-.186a.933.933 0 0 0 .294-.42c.068-.271-.141-.742-.369-.83-.083-.032-.8-.058-1.594-.058-1.408 0-1.449.006-1.673.229m4.2 0c-.25.251-.285.48-.125.83.169.37.459.435 1.961.435h1.403l.273-.273c.15-.15.273-.341.273-.425 0-.23-.254-.672-.425-.738-.083-.032-.821-.058-1.641-.058-1.457 0-1.494.005-1.719.229M7.784 22.253c-.159.07-.317.197-.35.284-.033.087-.061 4.411-.061 9.608v9.449l.216.203.216.203h23.616l.203-.216.203-.216v-9.45c0-5.986-.034-9.513-.092-9.621-.05-.094-.224-.217-.387-.274-.21-.073-3.629-.102-11.785-.099-9.433.003-11.541.026-11.779.129m22.549 9.854V40.6H8.867V23.613h21.466v8.494M11.67 24.529c-.409.409-.341.889.169 1.191.152.09.362.315.466.501.475.843 1.176 3.037 1.7 5.318.247 1.074.257 1.177.114 1.257-.386.216-.96.853-1.249 1.387-.305.563-.317.62-.317 1.61 0 .942.022 1.069.263 1.54.344.673.982 1.315 1.637 1.646.485.246.609.268 1.554.268.99 0 1.047-.012 1.61-.317a3.683 3.683 0 0 0 1.595-1.674c.217-.463.248-.647.248-1.463 0-.815-.031-1-.248-1.463-.544-1.159-1.636-1.926-2.869-2.014l-.645-.046-.348-1.459a52.396 52.396 0 0 0-.656-2.482c-.171-.563-.294-1.04-.275-1.06.02-.019.536.24 1.146.575 1.235.679 4.057 2.09 4.654 2.326l.385.153-.138.588c-.318 1.358.251 2.891 1.357 3.657 1.645 1.14 3.983.705 5.037-.937 1.144-1.783.462-4.196-1.453-5.136-.482-.236-.629-.262-1.514-.262-.897 0-1.023.023-1.493.268-.282.147-.585.33-.673.407-.211.187-.428.125-1.787-.504-1.762-.815-6.084-3.139-7.032-3.781-.609-.413-.897-.435-1.238-.094m35.23.344c.462 0 .977-.035 1.143-.077l.304-.077v.416c0 .229.252 5.93.561 12.668.309 6.739.534 12.403.501 12.588-.212 1.17-1.195 2.035-2.424 2.133-.838.067-1.448-.162-2.059-.773-.909-.909-.894.306-.182-14.129.341-6.909.619-12.64.618-12.736-.002-.153.04-.164.348-.093.193.044.728.08 1.19.08m-22.113 4.984c.967.439 1.429 1.695.984 2.675-.357.784-1.414 1.37-2.177 1.205-1.055-.228-1.754-1.063-1.753-2.097.001-.709.614-1.579 1.308-1.856.383-.153 1.224-.115 1.638.073m-7.847 4.139c.351.185.724.583.932.995.248.49.166 1.463-.163 1.934-.76 1.088-2.229 1.235-3.149.315a2.019 2.019 0 0 1-.229-2.613 2.036 2.036 0 0 1 2.609-.631m29.413 10.251-.246.193v4.826l.246.194c.135.106.339.193.454.193.114 0 .318-.087.454-.193l.246-.194V44.44l-.246-.193c-.136-.107-.34-.194-.454-.194-.115 0-.319.087-.454.194"
                                                                        fill-rule="evenodd"></path>
                                                                </svg>
                                                                <span class="ms-2">Baby Care</span>
                                                            </span>
                                                            <i class="feather-icon icon-chevron-right"></i>
                                                        </a>

                                                        <!-- collapse
                                                        <div id="flush-collapseFive" class="accordion-collapse collapse"
                                                            data-bs-parent="#categoryCollapseMenu">
                                                            <div>
                                                                <ul class="nav flex-column ms-8">
                                                                    <!-- nav item
                                                                    <li class="nav-item">
                                                                        <a class="nav-link active" aria-current="page"
                                                                            href="javascript:void(0)">Diapers, Wipes &
                                                                            More</a>
                                                                    </li>
                                                                    <!-- nav item
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Baby Food</a>
                                                                    </li>
                                                                    <!-- nav item 
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Bath & Hair
                                                                            Care</a>
                                                                    </li>
                                                                    <!-- nav item 
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Oral & Nasal
                                                                            Care</a>
                                                                    </li>
                                                                    <!-- nav item 
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Baby Skin Care
                                                                            Online</a>
                                                                    </li>
                                                                    <!-- nav item 
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Cleaning Needs
                                                                            Online</a>
                                                                    </li>
                                                                    <!-- nav item 
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Feeding
                                                                            Accessories Online</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>-->
                                                    </li>
                                                    <!-- panes item -->

                                                    <!-- pez item 
                                                    <li class="nav-item w-100 collapsed px-4 py-1">
                                                        <a href="javascript:void(0)" class="nav-link"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#flush-collapseSeven" aria-expanded="false"
                                                            aria-controls="flush-collapseSeven">
                                                            <span class="d-flex align-items-center">
                                                                <svg  width="24" height="24" viewBox="0 0 300 300"
                                                                    fill="#3d4f58" xmlns="http://www.w3.org/2000/svg">
                                                                    <g transform="translate(0,300) scale(0.1,-0.1)"
                                                                    fill-rule="evenodd" >
                                                                        <path
                                                                            d="M414 2971 c-48 -22 -105 -78 -131 -129 -26 -52 -25 -182 1 -237 12
                                                                              -25 132 -154 322 -344 l303 -305 -35 -38 c-19 -21 -34 -45 -34 -54 0 -9 20
                                                                              -36 44 -60 24 -24 43 -44 42 -44 0 0 -41 -2 -91 -5 -388 -19 -723 -298 -810
                                                                              -675 -16 -72 -20 -164 -6 -156 5 4 19 47 31 98 54 232 158 400 323 524 128 96
                                                                              262 147 434 164 105 11 143 25 143 55 0 6 -13 29 -30 51 -16 21 -30 43 -30 47
                                                                              0 4 11 25 25 45 14 20 25 45 25 56 0 12 -112 132 -299 320 -219 220 -305 313
                                                                              -320 346 -28 61 -27 132 3 196 27 57 63 89 150 129 l59 28 70 -34 c67 -32 106
                                                                              -69 634 -595 310 -309 581 -578 603 -598 l40 -36 109 0 c354 0 564 -77 748
                                                                              -274 94 -99 191 -282 166 -307 -8 -8 -26 18 -62 87 -87 170 -197 283 -351 363
                                                                              -121 63 -198 83 -340 88 -124 5 -125 5 -149 -21 -22 -23 -23 -27 -9 -48 9 -13
                                                                              144 -152 302 -310 157 -158 286 -292 286 -297 0 -40 -221 -53 -427 -26 l-136
                                                                              19 -18 -23 c-14 -17 -19 -40 -19 -90 0 -261 -120 -500 -336 -672 -82 -65 -93
                                                                              -84 -65 -113 21 -21 28 -21 339 -20 292 1 323 3 397 23 231 62 412 210 523
                                                                              428 26 51 53 93 60 93 18 0 15 -23 -13 -86 -40 -90 -109 -186 -189 -261 -116
                                                                              -111 -230 -171 -415 -217 -136 -35 -154 -45 -75 -46 164 -1 376 96 528 239 73
                                                                              70 164 206 201 300 25 63 27 74 15 96 -16 30 -50 41 -78 26 -10 -6 -30 -38
                                                                              -42 -72 -34 -91 -107 -195 -191 -274 -91 -85 -161 -127 -276 -168 -86 -30 -92
                                                                              -31 -298 -34 -115 -2 -272 -4 -348 -6 -75 -1 -137 0 -137 3 0 3 21 16 47 30
                                                                              67 35 192 161 251 253 92 142 148 334 140 484 -2 40 -2 73 -1 73 1 0 32 -8 70
                                                                              -17 52 -13 114 -17 263 -18 202 0 238 4 264 31 36 35 23 52 -296 372 l-313
                                                                              314 130 -5 c96 -3 148 -11 200 -27 224 -71 406 -235 491 -444 32 -77 57 -97
                                                                              99 -78 38 17 39 49 6 129 -118 287 -382 489 -696 532 -42 6 -138 11 -213 11
                                                                              l-137 0 -600 600 c-416 415 -611 604 -637 615 -54 22 -182 20 -234 -4z" />
                                                                                      <path d="M455 2906 c-107 -47 -150 -188 -86 -287 16 -24 157 -171 313 -326
                                                                              220 -219 290 -283 309 -283 44 0 259 215 259 258 0 22 -586 609 -632 633 -43
                                                                              22 -119 25 -163 5z m149 -41 c17 -8 163 -147 324 -308 l292 -292 -113 -113
                                                                              -113 -112 -306 307 c-284 286 -306 311 -313 351 -9 54 25 127 74 159 40 27
                                                                              107 30 155 8z" />
                                                                                      <path d="M507 2752 c-10 -10 -17 -28 -17 -40 0 -55 81 -71 109 -21 13 24 13
                                                                              29 -2 53 -21 31 -66 35 -90 8z" />
                                                                                      <path
                                                                                          d="M1118 2052 c-186 -185 -185 -184 -107 -267 28 -30 59 -57 68 -59 9
                                                                              -3 67 -10 128 -16 62 -6 143 -20 180 -31 244 -76 441 -259 534 -496 43 -110
                                                                              50 -123 79 -138 46 -24 202 -48 318 -49 108 -1 115 0 133 22 17 21 17 27 4 50
                                                                              -7 15 -265 278 -572 585 -433 432 -564 557 -583 557 -18 0 -64 -40 -182 -158z
                                                                              m757 -442 c313 -313 566 -573 562 -577 -12 -11 -295 14 -372 34 l-69 18 -17
                                                                              57 c-26 90 -84 198 -153 285 -152 191 -382 310 -639 329 l-92 7 -50 46 c-27
                                                                              25 -51 49 -53 53 -3 6 297 315 308 317 3 1 261 -255 575 -569z" />
                                                                                      <path d="M731 1669 c-290 -57 -527 -272 -621 -564 -30 -91 -37 -297 -15 -395
                                                                              70 -302 297 -535 594 -611 93 -24 252 -25 359 -3 84 17 213 73 288 125 114 78
                                                                              234 230 287 362 95 238 67 521 -73 730 -125 186 -312 313 -518 353 -80 15
                                                                              -231 17 -301 3z m292 -43 c359 -69 618 -385 617 -754 -1 -202 -77 -378 -230
                                                                              -532 -102 -103 -217 -168 -356 -201 -125 -30 -294 -24 -409 15 -227 77 -408
                                                                              256 -489 484 -29 82 -31 95 -31 237 0 173 10 217 83 360 77 151 227 285 393
                                                                              352 130 52 279 66 422 39z" />
                                                                                      <path d="M1015 1453 c-127 -28 -206 -124 -206 -249 0 -142 107 -246 252 -245
                                                                              137 0 242 108 243 246 0 132 -91 232 -224 248 -25 3 -54 3 -65 0z m123 -58
                                                                              c78 -33 122 -101 122 -190 0 -120 -85 -205 -205 -205 -120 0 -204 86 -205 208
                                                                              0 116 85 201 203 202 26 0 64 -7 85 -15z" />
                                                                                      <path d="M982 1359 c-73 -36 -116 -130 -93 -201 15 -45 74 -104 117 -118 108
                                                                              -36 236 70 221 181 -8 58 -50 117 -100 140 -55 24 -92 24 -145 -2z m151 -45
                                                                              c32 -23 57 -72 57 -111 0 -62 -72 -133 -135 -133 -62 0 -135 71 -135 133 0 47
                                                                              45 112 90 130 27 11 97 0 123 -19z" />
                                                                                      <path d="M517 1272 c-35 -38 -9 -102 40 -102 49 0 72 76 31 104 -29 21 -51 20
                                                                              -71 -2z" />
                                                                                      <path d="M438 981 c-100 -32 -159 -113 -159 -217 0 -128 94 -224 221 -224 227
                                                                              0 311 301 116 415 -49 29 -132 41 -178 26z m150 -59 c57 -26 86 -75 90 -151 3
                                                                              -56 0 -71 -20 -101 -61 -90 -173 -115 -258 -57 -53 36 -73 70 -78 135 -11 150
                                                                              125 239 266 174z" />
                                                                                      <path d="M450 904 c-29 -12 -80 -68 -91 -101 -22 -67 16 -143 88 -175 59 -26
                                                                              105 -16 154 33 64 64 62 143 -6 209 -27 26 -44 33 -82 36 -26 2 -55 1 -63 -2z
                                                                              m126 -68 c25 -25 34 -43 34 -67 0 -85 -81 -139 -154 -104 -106 50 -71 205 46
                                                                              205 32 0 47 -7 74 -34z" />
                                                                                      <path d="M1040 855 c-105 -33 -180 -138 -180 -250 1 -239 297 -346 453 -164
                                                                              107 125 73 313 -70 391 -62 34 -141 43 -203 23z m201 -70 c23 -17 53 -50 66
                                                                              -75 21 -38 24 -56 21 -117 -3 -62 -7 -76 -34 -110 -63 -79 -144 -108 -234 -84
                                                                              -128 34 -197 179 -140 296 26 55 40 70 91 100 38 22 53 25 116 23 61 -3 78 -8
                                                                              114 -33z" />
                                                                                      <path d="M1045 775 c-104 -56 -138 -162 -82 -258 44 -74 119 -108 196 -87 87
                                                                              23 150 115 138 201 -6 43 -42 97 -90 132 -36 27 -122 33 -162 12z m143 -45
                                                                              c50 -30 74 -76 69 -131 -5 -61 -36 -103 -92 -125 -59 -22 -110 -8 -154 41 -43
                                                                              49 -49 94 -20 152 40 78 127 106 197 63z" />
                                                                                      <path
                                                                                          d="M1391 1621 c-10 -7 9 -21 69 -51 192 -97 317 -230 393 -420 37 -93
                                                                              50 -185 45 -314 -8 -187 -70 -333 -203 -474 -78 -84 -151 -137 -256 -187 -63
                                                                              -30 -68 -35 -47 -40 52 -13 186 59 295 158 109 100 205 270 238 421 24 107 17
                                                                              291 -15 391 -66 207 -211 386 -389 478 -77 40 -111 50 -130 38z" />
                                                                                      <path
                                                                                          d="M1373 1578 c8 -13 46 -54 84 -93 119 -121 193 -247 234 -400 17 -62
                                                                              22 -109 22 -205 0 -144 -21 -237 -78 -357 -47 -100 -85 -154 -182 -254 -87
                                                                              -91 -106 -124 -52 -92 49 28 152 133 198 202 107 157 153 303 154 491 1 243
                                                                              -74 437 -237 609 -56 58 -134 121 -151 121 -4 0 0 -10 8 -22z" />
                                                                                      <path d="M2901 916 c-41 -44 -3 -106 55 -92 46 12 52 93 9 110 -28 10 -41 7
                                                                              -64 -18z" />
                                                                                      <path
                                                                                          d="M14 764 c24 -370 383 -726 756 -750 106 -7 92 6 -47 41 -134 34 -213
                                                                              67 -309 130 -185 124 -295 286 -359 530 -35 135 -48 150 -41 49z" />

                                                                    </g>
                                                                </svg>

                                                                <span class="ms-2"> Carnes y Fiambres</span>
                                                            </span>
                                                            <i class="feather-icon icon-chevron-right"></i>
                                                        </a>

                                                      
                                                        <div id="flush-collapseSeven"
                                                            class="accordion-collapse collapse"
                                                            data-bs-parent="#categoryCollapseMenu">
                                                            <div>
                                                                <ul class="nav flex-column ms-8">
                                                                    <!-- nav item 
                                                                    <li class="nav-item">
                                                                        <a class="nav-link active" aria-current="page"
                                                                            href="javascript:void(0)">Chicken</a>
                                                                    </li>
                                                                    <!-- nav item 
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Sausage, Salami &
                                                                            Ham</a>
                                                                    </li>
                                                                    <!-- nav item 
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Exotic Meat</a>
                                                                    </li>
                                                                    <!-- nav item
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Eggs</a>
                                                                    </li>
                                                                    <!-- nav item 
                                                                    <li class="nav-item">
                                                                        <a class="nav-link"
                                                                            href="javascript:void(0)">Frozen Non-Veg
                                                                            Snacks</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li> -->
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="card mb-6">
                                            <div class="card-body d-flex align-items-center">
                                                <div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        fill="var(--fc-primary)" class="bi bi-phone"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
                                                        <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                                    </svg>
                                                </div>
                                                <div class="ms-3">
                                                    <p class="mb-0 small">
                                                        Contactanos en <strong><a
                                                                href="mailto:soporte@wolchuk.com">Soporte</a></strong>
                                                        para asistencia con tus pedidos.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="card-body d-flex align-items-center border-top">
                                                <div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        fill="var(--fc-primary)" class="bi bi-calendar-range"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-12a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h1V.5a.5.5 0 0 1 .5-.5zM1 4v11h14V4H1z" />
                                                        <path
                                                            d="M4 8h2v2H4V8zM7 8h2v2H7V8zM10 8h2v2h-2V8zM4 11h2v2H4v-2zM7 11h2v2H7v-2z" />
                                                    </svg>

                                                </div>
                                                <div class="ms-3">
                                                    <p class="mb-0 small">
                                                        Realizá tu pedido hoy y recibí tu mercadería según el cronograma
                                                        de entregas de tu zona.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="card-body d-flex align-items-center border-top">
                                                <div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        fill="var(--fc-primary)" class="bi bi-bag-check"
                                                        viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                                                        <path
                                                            d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                                                    </svg>
                                                </div>
                                                <div class="ms-3">
                                                    <p class="mb-0 small">
                                                        Comprá con confianza. Somos una Distribuidora con más de 10 años
                                                        en el mercado.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="card-body d-flex align-items-center border-top">
                                                <div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        fill="var(--fc-primary)" class="bi bi-clock-history"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z" />
                                                        <path
                                                            d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z" />
                                                        <path
                                                            d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z" />
                                                    </svg>
                                                </div>
                                                <div class="ms-3">
                                                    <p class="mb-0 small">
                                                        Nuestra plataforma de pedidos está disponible las 24 horas del
                                                        día, todos los días.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-8">
                                            <!-- title -->


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                    <div class="col-xl-9 col-lg-8 col-md-12 mb-6 mb-md-0">
                        <div class="mb-12 product-content">
                            <div class="mb-6">
                                <h3 class="mb-0">Ofertas de la semana</h3>
                            </div>
                            <div class="product-slider-four-column">
                                <!-- item -->
                                <div class="item">
                                    <!-- card -->
                                    <div class="card card-product mb-4">
                                        <div class="card-body text-center py-8">
                                            <!-- img -->
                                            <a href="#"><img
                                                    src="dist/assets/images/category/category-snack-munchies.jpg"
                                                    alt="Grocery Ecommerce Template" class="mb-3" /></a>
                                            <!-- text -->
                                        </div>
                                    </div>
                                    <div>
                                        <span class="badge bg-danger rounded-pill">-45%</span>
                                        <h2 class="mt-3 fs-6">
                                            <a href="#" class="text-inherit">Salted Instant Popcorn</a>
                                        </h2>
                                        <div>
                                            <span class="text-dark fs-5 fw-bold">$18</span>
                                            <span class="text-decoration-line-through text-muted">$24</span>
                                        </div>
                                        <div class="text-warning">
                                            <!-- rating -->
                                            <small>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-half"></i>
                                            </small>
                                            <span class="text-muted small">4.5</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- item -->
                                <div class="item">
                                    <!-- card -->
                                    <div class="card card-product mb-4">
                                        <div class="card-body text-center py-8">
                                            <!-- img -->
                                            <a href="#"><img
                                                    src="dist/assets/images/category/category-dairy-bread-eggs.jpg"
                                                    alt="Grocery Ecommerce Template" class="mb-3" /></a>
                                            <!-- text -->
                                        </div>
                                    </div>
                                    <div>
                                        <span class="badge bg-danger rounded-pill">-12%</span>
                                        <h2 class="mt-3 fs-6">
                                            <a href="#" class="text-inherit">Blueberry Greek Yogurt</a>
                                        </h2>
                                        <div>
                                            <span class="text-dark fs-5 fw-bold">$15</span>
                                            <span class="text-decoration-line-through text-muted">$20</span>
                                        </div>
                                        <div class="text-warning">
                                            <!-- rating -->
                                            <small>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </small>
                                            <span class="text-muted small">5.0</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- item -->
                                <div class="item">
                                    <!-- card -->
                                    <div class="card card-product mb-4">
                                        <div class="card-body text-center py-8">
                                            <!-- img -->
                                            <a href="#"><img
                                                    src="dist/assets/images/category/category-snack-munchies.jpg"
                                                    alt="Grocery Ecommerce Template" class="mb-3" /></a>
                                            <!-- text -->
                                        </div>
                                    </div>
                                    <div>
                                        <span class="badge bg-danger rounded-pill">-55%</span>
                                        <h2 class="mt-3 fs-6">
                                            <a href="#" class="text-inherit">Kellogg s Original Cereals</a>
                                        </h2>
                                        <div>
                                            <span class="text-dark fs-5 fw-bold">$18</span>
                                            <span class="text-decoration-line-through text-muted">$24</span>
                                        </div>
                                        <div class="text-warning">
                                            <!-- rating -->
                                            <small>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-half"></i>
                                                <i class="bi bi-star-half"></i>
                                            </small>
                                            <span class="text-muted small">3.5</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- item -->
                                <div class="item">
                                    <!-- card -->
                                    <div class="card card-product mb-4">
                                        <div class="card-body text-center py-8">
                                            <!-- img -->
                                            <a href="#"><img
                                                    src="dist/assets/images/category/category-tea-coffee-drinks.jpg"
                                                    alt="Grocery Ecommerce Template" class="mb-3" /></a>
                                            <!-- text -->
                                        </div>
                                    </div>
                                    <div>
                                        <span class="badge bg-danger rounded-pill">-45%</span>
                                        <h2 class="mt-3 fs-6">
                                            <a href="#" class="text-inherit">Tea Coffee & Drinks</a>
                                        </h2>
                                        <div>
                                            <span class="text-dark fs-5 fw-bold">$18</span>
                                            <span class="text-decoration-line-through text-muted">$24</span>
                                        </div>
                                        <div class="text-warning">
                                            <!-- rating -->
                                            <small>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-half"></i>
                                            </small>
                                            <span class="text-muted small">4.5</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- item -->
                                <div class="item">
                                    <!-- card -->
                                    <div class="card card-product mb-4">
                                        <div class="card-body text-center py-8">
                                            <!-- img -->
                                            <a href="#"><img
                                                    src="dist/assets/images/category/category-bakery-biscuits.jpg"
                                                    alt="Grocery Ecommerce Template" class="mb-3" /></a>
                                            <!-- text -->
                                        </div>
                                    </div>
                                    <div>
                                        <span class="badge bg-danger rounded-pill">-25%</span>
                                        <h2 class="mt-3 fs-6">
                                            <a href="#" class="text-inherit">Slurrp Millet Chocolate</a>
                                        </h2>
                                        <div>
                                            <span class="text-dark fs-5 fw-bold">$120</span>
                                            <span class="text-decoration-line-through text-muted">$165</span>
                                        </div>
                                        <div class="text-warning">
                                            <!-- rating -->
                                            <small>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-half"></i>
                                            </small>
                                            <span class="text-muted small">4.5</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- item -->
                                <div class="item">
                                    <!-- card -->
                                    <div class="card card-product mb-4">
                                        <div class="card-body text-center py-8">
                                            <!-- img -->
                                            <a href="#"><img
                                                    src="dist/assets/images/category/category-atta-rice-dal.jpg"
                                                    alt="Grocery Ecommerce Template" class="mb-3" /></a>
                                            <!-- text -->
                                        </div>
                                    </div>
                                    <div>
                                        <span class="badge bg-danger rounded-pill">-55%</span>
                                        <h2 class="mt-3 fs-6">
                                            <a href="#" class="text-inherit">Atta, Rice & Dal</a>
                                        </h2>
                                        <div>
                                            <span class="text-dark fs-5 fw-bold">$18</span>
                                            <span class="text-decoration-line-through text-muted">$24</span>
                                        </div>
                                        <div class="text-warning">
                                            <!-- rating -->
                                            <small>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-half"></i>
                                                <i class="bi bi-star-half"></i>
                                            </small>
                                            <span class="text-muted small">3.5</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- item -->
                                <div class="item">
                                    <!-- card -->
                                    <div class="card card-product mb-4">
                                        <div class="card-body text-center py-8">
                                            <!-- img -->
                                            <a href="#"><img
                                                    src="dist/assets/images/category/category-chicken-meat-fish.jpg"
                                                    alt="Grocery Ecommerce Template" class="mb-3" /></a>
                                            <!-- text -->
                                        </div>
                                    </div>
                                    <div>
                                        <span class="badge bg-danger rounded-pill">-45%</span>
                                        <h2 class="mt-3 fs-6">
                                            <a href="#" class="text-inherit">Chicken, Meat & Fish</a>
                                        </h2>
                                        <div>
                                            <span class="text-dark fs-5 fw-bold">$18</span>
                                            <span class="text-decoration-line-through text-muted">$24</span>
                                        </div>
                                        <div class="text-warning">
                                            <!-- rating -->
                                            <small>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-half"></i>
                                            </small>
                                            <span class="text-muted small">4.5</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- item -->
                                <div class="item">
                                    <!-- card -->
                                    <div class="card card-product mb-4">
                                        <div class="card-body text-center py-8">
                                            <!-- img -->
                                            <a href="#"><img
                                                    src="dist/assets/images/category/category-cleaning-essentials.jpg"
                                                    alt="Grocery Ecommerce Template" class="mb-3" /></a>
                                            <!-- text -->
                                        </div>
                                    </div>
                                    <div>
                                        <span class="badge bg-danger rounded-pill">-25%</span>
                                        <h2 class="mt-3 fs-6">
                                            <a href="#" class="text-inherit">Cleaning Essentials</a>
                                        </h2>
                                        <div>
                                            <span class="text-dark fs-5 fw-bold">$120</span>
                                            <span class="text-decoration-line-through text-muted">$165</span>
                                        </div>
                                        <div class="text-warning">
                                            <!-- rating -->
                                            <small>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-half"></i>
                                            </small>
                                            <span class="text-muted small">4.5</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <!-- cta -->
                            <div
                                class="bg-light d-lg-flex justify-content-between align-items-center py-6 py-lg-3 px-8 text-center text-lg-start rounded">
                                <!-- img -->
                                <div class="d-lg-flex align-items-center">
                                    <img src="src/assets/images/about/about-icons-1.svg" alt="" class="img-fluid">
                                    <!-- text -->

                                    <div class="ms-lg-4">
                                        <h1 class="fs-2 mb-1">¿Te enviamos ofertas semanales?</h1>
                                        <span>
                                            Suscríbete y no te pierdas los
                                            <span class="text-primary">descuentos</span>
                                            más exclusivos que tenemos para ti.

                                        </span>
                                    </div>
                                </div>
                                <div class="mt-3 mt-lg-0">
                                    <!-- btn -->
                                    <a href="#" class="btn btn-dark">Suscribirme</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- COMIENZO ARTICULOS -->
                    <div class="row">
                        <div class="col-12">
                            <div class="row align-items-center mb-6">
                                <div class="col-xl-10 col-lg-9 col-8">
                                    <div class="mb-4 mb-lg-0">
                                        <h3 class="mb-1">Nuestros Productos</h3>
                                        <p class="mb-0">Nuevos productos con stock actualizado.</p>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-4 text-end">
                                    <a href="./pages/main/ver_todos_index.php" class="btn btn-light">Ver Todos</a>
                                </div>
                            </div>

                            <div class="row row-cols-xl-4 row-cols-lg-3 g-4">
                                <?php foreach ($articulos as $articulo): ?>
                                <div class="col">
                                    <div class="mb-6">
                                        <!-- Tarjeta del producto -->
                                        <div class="card card-product mb-4">
                                            <div class="card-body text-center py-8">
                                                <!-- Imagen del producto -->
                                                <a href="ver_articulo.php?id=<?= $articulo['id']; ?>">
                                                    <img src="../../<?= !empty($articulo['ruta_imagen']) ? $articulo['ruta_imagen'] : 'assets/imagenes/articulos/default.png'; ?>"
                                                        alt="<?= htmlspecialchars($articulo['descripcion']); ?>"
                                                        class="mb-3 img-fluid"
                                                        style="height: 200px; object-fit: cover;">
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Información del producto -->
                                        <div>
                                            <h2 class="mt-3 fs-6">
                                                <a href="ver_articulo.php?id=<?= $articulo['id']; ?>"
                                                    class="text-inherit">
                                                    <?= htmlspecialchars($articulo['descripcion']); ?>
                                                </a>
                                            </h2>
                                            <div>
                                                <span class="text-dark fs-5 fw-bold">
                                                    $<?= number_format($articulo['precio'], 2, ',', '.'); ?>
                                                </span>
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

                            <!-- Botón para ver más productos -->
                            <div class="text-center mt-4">
                                <a href="ver_todos.php" class="btn btn-primary">Ver Más Productos</a>
                            </div>
                        </div>

                    </div>
                    <!-- FIN ARTICULOS -->

                </div>
            </div>
        </div>

        <section class="my-lg-14 my-8">
            <div class="container">
                <div class="row align-items-center mb-8">
                    <div class="col-md-8 col-12">
                        <!-- heading -->
                        <div class="d-flex">
                            <div class="mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    class="bi bi-journal text-primary" viewBox="0 0 16 16">
                                    <path
                                        d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z">
                                    </path>
                                    <path
                                        d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ms-3">
                                <h3 class="mb-0">Our most popular recipes</h3>
                                <p class="mb-0">
                                    Check out most popular recipes of all time.
                                </p>
                            </div>
                            <div></div>
                        </div>
                    </div>
                    <!-- button -->
                    <div class="col-md-4 text-end d-none d-md-block">
                        <a href="#" class="btn btn-primary">View all recipes</a>
                    </div>
                </div>
                <div class="row">
                    <!-- col -->
                    <div class="col-12 col-md-6 col-lg-3 mb-8">
                        <div class="mb-4">
                            <a href="javascript:void(0)">
                                <!-- img -->
                                <div class="img-zoom">
                                    <img src="dist/assets/images/blog/blog-img-1.jpg" alt=""
                                        class="img-fluid rounded w-100" />
                                </div>
                            </a>
                        </div>
                        <!-- text -->
                        <div>
                            <h4 class="h5">
                                <a href="javascript:void(0)" class="text-inherit">Spaghetti with Crispy Zucchini</a>
                            </h4>
                            <p>
                                Praesent vestibulum magna lacinia augue mollisvel aliquet
                                massa posuere. Duis et mauris tortor.
                            </p>
                            <div class="d-flex align-items-center lh-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                                    class="bi bi-clock text-dark" viewBox="0 0 16 16">
                                    <path
                                        d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z">
                                    </path>
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z">
                                    </path>
                                </svg>
                                <small class="ms-1">
                                    <span class="text-dark fw-bold">15</span>
                                    min
                                </small>
                            </div>
                        </div>
                    </div>
                    <!-- col -->
                    <div class="col-12 col-md-6 col-lg-3 mb-8">
                        <div class="mb-4">
                            <a href="javascript:void(0)">
                                <div class="img-zoom">
                                    <!-- img -->
                                    <img src="dist/assets/images/blog/blog-img-2.jpg" alt=""
                                        class="img-fluid rounded w-100" />
                                </div>
                            </a>
                        </div>
                        <!-- text -->
                        <div>
                            <h4 class="h5">
                                <a href="javascript:void(0)" class="text-inherit">Almond Butter Chocolate Chip Zucchini
                                    Bars</a>
                            </h4>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur sit amet tincidunt
                                ellentesque aliquet ligula in ultrices congue.
                            </p>
                            <div class="d-flex align-items-center lh-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                                    class="bi bi-clock text-dark" viewBox="0 0 16 16">
                                    <path
                                        d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z">
                                    </path>
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z">
                                    </path>
                                </svg>
                                <small class="ms-1">
                                    <span class="text-dark fw-bold">18</span>
                                    min
                                </small>
                            </div>
                        </div>
                    </div>
                    <!-- col -->
                    <div class="col-12 col-md-6 col-lg-3 mb-8">
                        <div class="mb-4">
                            <a href="javascript:void(0)">
                                <!-- img -->
                                <div class="img-zoom">
                                    <img src="dist/assets/images/blog/blog-img-3.jpg" alt=""
                                        class="img-fluid rounded w-100" />
                                </div>
                            </a>
                        </div>
                        <!-- text -->
                        <div>
                            <h4 class="h5">
                                <a href="javascript:void(0)" class="text-inherit">Spicy Shrimp Tacos Garlic Cilantro
                                    Lime Slaw</a>
                            </h4>
                            <p>
                                Praesent vestibulum magna lacinia augue mollisvel aliquet
                                massa posuere. Duis et mauris tortor.
                            </p>
                            <div class="d-flex align-items-center lh-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                                    class="bi bi-clock text-dark" viewBox="0 0 16 16">
                                    <path
                                        d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z">
                                    </path>
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z">
                                    </path>
                                </svg>
                                <small class="ms-1">
                                    <span class="text-dark fw-bold">20</span>
                                    min
                                </small>
                            </div>
                        </div>
                    </div>
                    <!-- col -->
                    <div class="col-12 col-md-6 col-lg-3 mb-8">
                        <div class="mb-4">
                            <a href="javascript:void(0)">
                                <!-- img -->
                                <div class="img-zoom">
                                    <img src="dist/assets/images/blog/blog-img-4.jpg" alt=""
                                        class="img-fluid rounded w-100" />
                                </div>
                            </a>
                        </div>
                        <div>
                            <h4 class="h5">
                                <a href="javascript:void(0)" class="text-inherit">Simple Homemade Tomato Soup</a>
                            </h4>
                            <p>
                                Aliquam tempus velit augue, sodales tincidunt augue ipsum
                                primis in faucibus orci luctus et ultrices posuere cubilia
                            </p>
                            <div class="d-flex align-items-center lh-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                                    class="bi bi-clock text-dark" viewBox="0 0 16 16">
                                    <path
                                        d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z">
                                    </path>
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z">
                                    </path>
                                </svg>
                                <small class="ms-1">
                                    <span class="text-dark fw-bold">9</span>
                                    min
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        </div>
    </main>

    <!-- Modal -->


    <!-- modal -->
    <!-- Modal -->
    <div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-8">
                    <div class="position-absolute top-0 end-0 me-3 mt-3">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- img slide -->
                            <div class="product productModal" id="productModal">
                                <div class="zoom" onmousemove="zoom(event)" style="
                      background-image: url(dist/assets/images/products/product-single-img-1.jpg);
                    ">
                                    <!-- img -->
                                    <img src="dist/assets/images/products/product-single-img-1.jpg" alt="" />
                                </div>
                                <div>
                                    <div class="zoom" onmousemove="zoom(event)" style="
                        background-image: url(dist/assets/images/products/product-single-img-2.jpg);
                      ">
                                        <!-- img -->
                                        <img src="dist/assets/images/products/product-single-img-2.jpg" alt="" />
                                    </div>
                                </div>
                                <div>
                                    <div class="zoom" onmousemove="zoom(event)" style="
                        background-image: url(dist/assets/images/products/product-single-img-3.jpg);
                      ">
                                        <!-- img -->
                                        <img src="dist/assets/images/products/product-single-img-3.jpg" alt="" />
                                    </div>
                                </div>
                                <div>
                                    <div class="zoom" onmousemove="zoom(event)" style="
                        background-image: url(dist/assets/images/products/product-single-img-4.jpg);
                      ">
                                        <!-- img -->
                                        <img src="dist/assets/images/products/product-single-img-4.jpg" alt="" />
                                    </div>
                                </div>
                            </div>
                            <!-- product tools -->
                            <div class="product-tools">
                                <div class="thumbnails row g-3" id="productModalThumbnails">
                                    <div class="col-3" class="tns-nav-active">
                                        <div class="thumbnails-img">
                                            <!-- img -->
                                            <img src="dist/assets/images/products/product-single-img-1.jpg" alt="" />
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="thumbnails-img">
                                            <!-- img -->
                                            <img src="dist/assets/images/products/product-single-img-2.jpg" alt="" />
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="thumbnails-img">
                                            <!-- img -->
                                            <img src="dist/assets/images/products/product-single-img-3.jpg" alt="" />
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="thumbnails-img">
                                            <!-- img -->
                                            <img src="dist/assets/images/products/product-single-img-4.jpg" alt="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="ps-lg-8 mt-6 mt-lg-0">
                                <a href="#!" class="mb-4 d-block">Bakery Biscuits</a>
                                <h2 class="mb-1 h1">Napolitanke Ljesnjak</h2>
                                <div class="mb-4">
                                    <small class="text-warning">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i></small><a href="#" class="ms-2">(30 reviews)</a>
                                </div>
                                <div class="fs-4">
                                    <span class="fw-bold text-dark">$32</span>
                                    <span class="text-decoration-line-through text-muted">$35</span><span><small
                                            class="fs-6 ms-2 text-danger">26% Off</small></span>
                                </div>
                                <hr class="my-6" />
                                <div class="mb-4">
                                    <button type="button" class="btn btn-outline-secondary">
                                        250g
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary">
                                        500g
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary">
                                        1kg
                                    </button>
                                </div>
                                <div>
                                    <!-- input -->
                                    <!-- input -->
                                    <div class="input-group input-spinner">
                                        <input type="button" value="-" class="button-minus btn btn-sm"
                                            data-field="quantity" />
                                        <input type="number" step="1" max="10" value="1" name="quantity"
                                            class="quantity-field form-control-sm form-input" />
                                        <input type="button" value="+" class="button-plus btn btn-sm"
                                            data-field="quantity" />
                                    </div>
                                </div>
                                <div class="mt-3 row justify-content-start g-2 align-items-center">
                                    <div class="col-lg-4 col-md-5 col-6 d-grid">
                                        <!-- button -->
                                        <!-- btn -->
                                        <button type="button" class="btn btn-primary">
                                            <i class="feather-icon icon-shopping-bag me-2"></i>Add
                                            to cart
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-5">
                                        <!-- btn -->
                                        <a class="btn btn-light" href="#" data-bs-toggle="tooltip" data-bs-html="true"
                                            aria-label="Compare"><i class="bi bi-arrow-left-right"></i></a>
                                        <a class="btn btn-light" href="#!" data-bs-toggle="tooltip" data-bs-html="true"
                                            aria-label="Wishlist"><i class="feather-icon icon-heart"></i></a>
                                    </div>
                                </div>
                                <hr class="my-6" />
                                <div>
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td>Product Code:</td>
                                                <td>FBB00255</td>
                                            </tr>
                                            <tr>
                                                <td>Availability:</td>
                                                <td>In Stock</td>
                                            </tr>
                                            <tr>
                                                <td>Type:</td>
                                                <td>Fruits</td>
                                            </tr>
                                            <tr>
                                                <td>Shipping:</td>
                                                <td>
                                                    <small>01 day shipping.<span class="text-muted">( Free pickup
                                                            today)</span></small>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <!-- footer -->
    <footer class="footer bg-dark pb-6 pt-4 pt-md-12">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-8 col-md-12 col-lg-4">
                    <a href="#"><img src="dist/assets/images/logo/freshcart-white-logo.svg" alt="" /></a>
                </div>
                <div class="col-4 col-md-12 col-lg-8 text-end">
                    <ul class="list-inline text-md-end mb-0 small">
                        <li class="list-inline-item me-2">
                            <a href="#!" class="social-links">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-facebook" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                                </svg>
                            </a>
                        </li>
                        <li class="list-inline-item me-2">
                            <a href="#!" class="social-links">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-twitter" viewBox="0 0 16 16">
                                    <path
                                        d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                                </svg>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#!" class="social-links">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-instagram" viewBox="0 0 16 16">
                                    <path
                                        d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="my-lg-8 opacity-25" />
            <div class="row g-4">
                <div class="col-12 col-md-12 col-lg-4">
                    <h6 class="mb-4 text-white">Categories</h6>
                    <div class="row">
                        <div class="col-6">
                            <!-- list -->
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Lacteos</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Breakfast & instant food</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Bakery & Biscuits</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Atta, rice & dal</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Sauces & spreads</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Organic & gourmet</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Baby care</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Cleaning essentials</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Personal care</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <!-- list -->
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Dairy, bread & eggs</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Cold drinks & juices</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Tea, coffee & drinks</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Masala, oil & more</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Chicken, meat & fish</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Paan corner</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Pharma & wellness</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Home & office</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Pet care</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-8">
                    <div class="row g-4">
                        <div class="col-6 col-sm-6 col-md-3">
                            <h6 class="mb-4 text-white">Get to know us</h6>
                            <!-- list -->
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Company</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">About</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Blog</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Help Center</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Our Value</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3">
                            <h6 class="mb-4 text-white">For Consumers</h6>
                            <ul class="nav flex-column">
                                <!-- list -->
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Payments</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Shipping</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Product Returns</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">FAQ</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Shop Checkout</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3">
                            <h6 class="mb-4 text-white">Become a Shopper</h6>
                            <ul class="nav flex-column">
                                <!-- list -->
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Shopper Opportunities</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Become a Shopper</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Earnings</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Ideas & Guides</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">New Retailers</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3">
                            <h6 class="mb-4 text-white">Freshcart programs</h6>
                            <ul class="nav flex-column">
                                <!-- list -->
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Freshcart programs</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Gift Cards</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Promos & Coupons</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Freshcart Ads</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#!" class="nav-link">Careers</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="mt-8 opacity-25" />
            <div>
                <div class="row gy-4 align-items-center">
                    <div class="col-md-6">
                        <span class="small text-muted">
                            © 2022
                            <span id="copyright">
                                -
                                <script>
                                document
                                    .getElementById("copyright")
                                    .appendChild(
                                        document.createTextNode(new Date().getFullYear())
                                    );
                                </script>
                            </span>
                            FreshCart eCommerce HTML Template. All rights reserved. Powered
                            by
                            <a href="https://codescandy.com/">Codescandy</a>
                            .
                        </span>
                    </div>
                    <div class="col-lg-6 text-end mb-2 mb-lg-0">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item text-light">Payment Partners</li>
                            <li class="list-inline-item">
                                <a href="#!"><img src="dist/assets/images/payment/amazonpay.svg" alt="" /></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#!"><img src="dist/assets/images/payment/american-express.svg" alt="" /></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#!"><img src="dist/assets/images/payment//mastercard.svg" alt="" /></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#!"><img src="dist/assets/images/payment/paypal.svg" alt="" /></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#!"><img src="dist/assets/images/payment/visa.svg" alt="" /></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Javascript-->
    <!-- Libs JS -->
    <!-- <script src="dist/assets/libs/jquery/dist/jquery.min.js"></script> -->
    <script src="dist/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="dist/assets/libs/simplebar/dist/simplebar.min.js"></script>

    <!-- Theme JS -->
    <script src="dist/assets/js/theme.min.js"></script>

    <script src="dist/assets/js/vendors/jquery.min.js"></script>
    <script src="dist/assets/libs/slick-carousel/slick/slick.min.js"></script>
    <script src="dist/assets/js/vendors/slick-slider.js"></script>
    <script src="dist/assets/libs/tiny-slider/dist/min/tiny-slider.js"></script>
    <script src="dist/assets/js/vendors/tns-slider.js"></script>
    <script src="dist/assets/js/vendors/zoom.js"></script>

    <script src="dist/assets/js/vendors/countdown.js"></script>
    <script src="dist/assets/libs/sticky-sidebar/dist/sticky-sidebar.min.js"></script>
    <script src="dist/assets/js/vendors/sticky.js"></script>
    <script src="dist/assets/js/vendors/modal.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    document.getElementById("loginForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Evita que la página se recargue y muestre datos en la URL

        let usuario = document.getElementById("usuario").value.trim();
        let contrasena = document.getElementById("contrasena").value.trim();

        if (usuario === "" || contrasena === "") {
            Swal.fire({
                icon: "error",
                title: "Todos los campos son obligatorios.",
                showConfirmButton: false,
                timer: 2500
            });
            return;
        }

        // Crear objeto FormData para enviar los datos de manera segura
        let formData = new FormData();
        formData.append("usuario", usuario);
        formData.append("contrasena", contrasena);

        // Enviar datos a login.php con fetch()
        fetch("./backend/controllers/login/login.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json()) // Convertir la respuesta en JSON
            .then(data => {
                Swal.fire({
                    icon: data.status === "success" ? "success" : "error",
                    title: data.message,
                    showConfirmButton: false,
                    timer: 2500
                });

                // Si el login es correcto, redirigir después de 2.5 segundos
                if (data.status === "success") {
                    setTimeout(() => {
                        window.location.href = "./pages/main/main.php"; // Redirigir al dashboard
                    }, 2500);
                }
            })
            .catch(error => {
                console.error("Error en el login:", error);
                Swal.fire({
                    icon: "error",
                    title: "Error inesperado. Inténtalo de nuevo.",
                    showConfirmButton: false,
                    timer: 2500
                });
            });
    });
    </script>




</body>

</html>