<?php
require_once '../../database/Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imagen']) && isset($_POST['id_articulo'])) {
    $database = new Database();
    $pdo = $database->getConnection();

    $idArticulo = $_POST['id_articulo'];

    // Obtener el código del artículo desde la BD
    $stmt = $pdo->prepare("SELECT codigo_generico FROM articulos WHERE id = :id");
    $stmt->bindParam(":id", $idArticulo, PDO::PARAM_INT);
    $stmt->execute();
    $articulo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$articulo) {
        die("❌ Error: El artículo no existe.");
    }

    // Normalizar el código del artículo
    $codigoArticulo = preg_replace('/[^a-zA-Z0-9]/', '_', $articulo['codigo_generico']); // Reemplazar caracteres no válidos
    $codigoArticulo = strtolower($codigoArticulo); // Convertir a minúsculas

    // Definir el directorio donde se guardará la imagen
    $directorio = __DIR__ . "/../../../assets/imagenes/articulos/";
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
    }

    // Generar nombre único para la imagen basado en el código del artículo
    $extension = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
    $nombreArchivo = "articulo_" . $codigoArticulo . "." . $extension;
    $rutaCompleta = $directorio . $nombreArchivo;
    $rutaBD = "assets/imagenes/articulos/" . $nombreArchivo; // Para guardar en BD

    // Verificar que el formato de la imagen es válido
    $permitidos = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($extension, $permitidos)) {
        die("❌ Error: Formato de imagen no permitido.");
    }

    // Subir la imagen y actualizar la base de datos
    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaCompleta)) {
        $stmt = $pdo->prepare("UPDATE articulos SET ruta_imagen = :ruta WHERE id = :id");
        $stmt->bindParam(":ruta", $rutaBD);
        $stmt->bindParam(":id", $idArticulo, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "✅ Imagen subida y guardada correctamente.";
        } else {
            echo "❌ Error al guardar la imagen en la base de datos.";
        }
    } else {
        echo "❌ Error al subir la imagen.";
    }

    $database->closeConnection();
} else {
    echo "❌ Error: Datos insuficientes.";
}
?>
