<?php
require_once '../../backend/database/Database.php';

$database = new Database();
$pdo = $database->getConnection();

// Obtener los artículos sin imagen
$stmt = $pdo->prepare("SELECT id, codigo_generico, descripcion FROM articulos WHERE ruta_imagen IS NULL OR ruta_imagen = ''");
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
                        <td><?= htmlspecialchars($articulo['id']); ?></td>
                        <td><?= htmlspecialchars($articulo['codigo_generico']); ?></td>
                        <td><?= htmlspecialchars($articulo['descripcion']); ?></td>
                        <td>
                            <form action="../../backend/controllers/imagenes/imagenes_controller.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id_articulo" value="<?= $articulo['id']; ?>">
                                <input type="file" name="imagen" required>
                                <button type="submit">Subir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Todos los artículos tienen imágenes.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
