<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();}
$usuarioActivo = isset($_SESSION['usuario']);
?>

<header>
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