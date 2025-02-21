<?php session_start(); ?>

<header>
    <div class="container">
        <div class="row align-items-center pt-2">
            <div class="col-xl-9 col-lg-4 col-5 d-md-flex align-items-center justify-content-end">
                
                <?php if (isset($_SESSION['usuario'])): ?>
                    <a href="#" class="text-reset">Bienvenido, <?php echo $_SESSION['usuario']; ?></a>
                    <a href="backend/controllers/login/logout.php" class="text-reset ms-4">Cerrar Sesión</a>
                <?php else: ?>
                    <a href="#" class="text-reset" data-bs-toggle="modal" data-bs-target="#loginModal">Iniciar Sesión</a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</header>

<!-- 🔹 MODAL DE LOGIN -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Iniciar Sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="loginForm">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Importamos el archivo de JavaScript externo -->
<script src="../../backend/controllers/login/login.php"></script>
