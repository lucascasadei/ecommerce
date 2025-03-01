<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();}
$usuarioActivo = isset($_SESSION['usuario']);
?>

<header>
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
                            <a href="./../../pages/signin.html">Sign in</a>
                            or
                            <a href="./../../pages/signup.html">Register</a>
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
                <a href="./../../pages/account-orders.html" class="text-inherit">
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
    <div class="container">


        <div class="row align-items-center pt-6 pb-4 mt-4 mt-lg-0">
            <div class="col-xl-2 col-md-3 mb-4 mb-md-0 col-12 text-center text-md-start">
                <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/ecommerce/config/config.php";
                      ?>
                <a href="<?php echo $usuarioActivo ? BASE_URL . '/pages/main/main.php' : BASE_URL . '/index.php'; ?>">
                    <img src="<?php echo BASE_URL; ?>/dist/assets/images/logo/logo.png" alt="Logo" width="80px" />
                </a>

            </div>
            <!-- Incluir SweetAlert2 -->
            <div class="col-xxl-6 col-xl-5 col-lg-6 col-md-9">
                <form action="#">
                    <div class="input-group">
                        <!-- Incluir SweetAlert2   <input class="form-control" type="search" placeholder="Buscar productos" aria-label="Buscar productos" aria-describedby="button-addon2"/>
             <button class="btn btn-primary" type="button" id="button-addon2">Buscar</button>-->
                    </div>
                </form>
            </div>

            <div class="col-xxl-4 col-xl-5 col-lg-3 d-none d-lg-block">
                <div class="d-flex align-items-center justify-content-between ms-4">
                    <div class="text-center">
                        <div class="dropdown">
                            <a href="#" class="text-reset" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="lh-1">
                                    <div class="position-relative d-inline-block mb-2">
                                        <i class="bi bi-bell fs-4"></i>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">1</span>
                                    </div>
                                    <p class="mb-0 d-none d-xl-block small">Notificaciones</p>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg p-0">
                                <div>
                                    <h6 class="px-4 border-bottom py-3 mb-0">Notificaciones</h6>
                                    <p class="mb-0 px-4 py-3">
                                        <a href="#">Inicia sesión</a> o <a href="#">regístrate</a> para no tener que
                                        ingresar tus datos cada vez.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (!$usuarioActivo): ?>
                    <div class="ms-6 text-center">
                        <a href="#" class="text-reset" data-bs-toggle="modal" data-bs-target="#userModal">
                            <div class="lh-1">
                                <div class="mb-2"><i class="bi bi-person-circle fs-4"></i></div>
                                <p class="mb-0 d-none d-xl-block small">Iniciar Sesión</p>
                            </div>
                        </a>
                    </div>
                    <?php else: ?>
                    <div class="ms-6 text-center">
                        <a href="#" class="text-reset btn-logout">
                            <div class="lh-1">
                                <div class="mb-2"><i class="bi bi-box-arrow-right fs-4"></i></div>
                                <p class="mb-0 d-none d-xl-block small">Cerrar Sesión</p>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>



                    <div class="ms-6 text-center">
                        <a href="./../main/verPedidos.php" class="text-reset">
                            <div class="lh-1">
                                <div class="mb-2"><i class="bi bi-archive fs-4"></i></div>
                                <p class="mb-0 d-none d-xl-block small">Mis Pedidos</p>
                            </div>
                        </a>
                    </div>
                    <div class="text-center ms-6">
                        <a href="./../carrito/carrito.php" class="text-reset">
                            <div class="text-center">
                                <div><i class="bi bi-cart2 fs-4"></i></div>
                                <p class="mb-0 d-none d-xl-block small">Carrito</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Incluir SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
document.addEventListener("DOMContentLoaded", function() {
    const logoutBtn = document.querySelector(".btn-logout");

    if (logoutBtn) {
        logoutBtn.addEventListener("click", function(event) {
            event.preventDefault();

            Swal.fire({
                title: "¿Seguro que quieres cerrar sesión?",
                text: "Tendrás que volver a iniciar sesión para acceder.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, cerrar sesión",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../header/logout.php";
                }
            });
        });
    }
});
</script>