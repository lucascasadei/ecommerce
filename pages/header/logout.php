<?php
session_start();
session_destroy();

// Redirige al index.php después de cerrar sesión
header("Location: ../../index.php");
exit;
?>
