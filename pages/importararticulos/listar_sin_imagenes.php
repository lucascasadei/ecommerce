<?php
require_once '../../backend/database/Database.php';

$database = new Database();
$pdo = $database->getConnection();

// Obtener los artículos con precio > 0 que NO tienen imagen en la tabla imagenes_articulos
$stmt = $pdo->prepare("
    SELECT a.codigo_generico, a.descripcion 
    FROM articulos a
    LEFT JOIN imagenes_articulos i ON a.codigo_generico = i.codigo_generico
    WHERE (i.ruta_imagen IS NULL OR i.codigo_generico IS NULL)
    AND a.precio > 0
");
$stmt->execute();
$articulos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$database->closeConnection();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Imágenes</title>
    <link rel="stylesheet" href="../../assets/css/styles.css"> <!-- Opcional -->
</head>
<body>
    <h2>Artículos sin Imagen</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Descripción</th>
                <th>Subir Imagen</th>
            </tr>
        </thead>
        <tbody>
    <?php if (!empty($articulos)): ?>
        <?php foreach ($articulos as $articulo): ?>
            <tr>
                <td><?= htmlspecialchars($articulo['codigo_generico']); ?></td>
                <td><?= htmlspecialchars($articulo['descripcion']); ?></td>
                <td>
                    <form action="../../backend/controllers/imagenes/imagenes_controller.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="codigo_generico" value="<?= $articulo['codigo_generico']; ?>">
                        <input type="file" name="imagen" required>
                        <button type="submit">Subir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">Todos los artículos tienen imágenes.</td>
        </tr>
    <?php endif; ?>
</tbody>


    </table>
</body>
</html>
