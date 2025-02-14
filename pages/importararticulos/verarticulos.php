<?php
require_once '../../backend/database/Database.php';

$database = new Database();
$pdo = $database->getConnection();

// Obtener ID o código del artículo desde la URL
$idArticulo = isset($_GET['id']) ? $_GET['id'] : null;
$codigoArticulo = isset($_GET['codigo']) ? $_GET['codigo'] : null;

if (!$idArticulo && !$codigoArticulo) {
    die("❌ Error: Debes proporcionar un ID o código de artículo en la URL.");
}

// Construir la consulta
if ($idArticulo) {
    $stmt = $pdo->prepare("SELECT id, codigo_generico, descripcion, ruta_imagen FROM articulos WHERE id = :id");
    $stmt->bindParam(":id", $idArticulo, PDO::PARAM_INT);
} else {
    $stmt = $pdo->prepare("SELECT id, codigo_generico, descripcion, ruta_imagen FROM articulos WHERE codigo_generico = :codigo");
    $stmt->bindParam(":codigo", $codigoArticulo, PDO::PARAM_STR);
}

$stmt->execute();
$articulo = $stmt->fetch(PDO::FETCH_ASSOC);
$database->closeConnection();

if (!$articulo) {
    die("❌ Error: No se encontró el artículo.");
}

// Definir la ruta de la imagen
$rutaImagen = !empty($articulo['ruta_imagen']) ? "../../" . $articulo['ruta_imagen'] : "../../assets/imagenes/articulos/default.png";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Artículo</title>
    <link rel="stylesheet" href="../../assets/css/styles.css"> <!-- Opcional -->
</head>
<body>
    <h2>Detalle del Artículo</h2>
    <p><strong>ID:</strong> <?= htmlspecialchars($articulo['id']); ?></p>
    <p><strong>Código:</strong> <?= htmlspecialchars($articulo['codigo_generico']); ?></p>
    <p><strong>Descripción:</strong> <?= htmlspecialchars($articulo['descripcion']); ?></p>
    <p><strong>Imagen:</strong></p>
    <img src="<?= htmlspecialchars($rutaImagen); ?>" alt="Imagen del artículo" width="300">
    <br>
    <a href="listar_sin_imagenes.php">Volver al listado</a>
</body>
</html>
