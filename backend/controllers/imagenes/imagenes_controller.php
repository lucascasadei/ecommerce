<?php
require_once '../../database/Database.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imagen']) && isset($_POST['codigo_generico'])) {
    $database = new Database();
    $pdo = $database->getConnection();

    $codigoGenerico = $_POST['codigo_generico'];

    // Normalizar el código del artículo para el nombre del archivo
    $codigoArticulo = preg_replace('/[^a-zA-Z0-9]/', '_', $codigoGenerico);
    $codigoArticulo = strtolower($codigoArticulo);

    // Definir el directorio donde se guardará la imagen
    $directorio = __DIR__ . "/../../../assets/imagenes/articulos/";
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
    }

    // Generar nombre único para la imagen basado en el código del artículo
    $extension = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
    $nombreArchivo = "articulo_" . $codigoArticulo . "." . $extension;
    $rutaCompleta = $directorio . $nombreArchivo;
    $rutaBD = "assets/imagenes/articulos/" . $nombreArchivo;

    // Verificar que el formato de la imagen es válido
    $permitidos = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($extension, $permitidos)) {
        die("❌ Error: Formato de imagen no permitido.");
    }

    // Subir la imagen y guardar en BD
    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaCompleta)) {
        // Insertar la imagen en la tabla `imagenes_articulos`
        $stmt = $pdo->prepare("
            INSERT INTO imagenes_articulos (codigo_generico, ruta_imagen) 
            VALUES (:codigo_generico, :ruta_imagen)
            ON DUPLICATE KEY UPDATE ruta_imagen = VALUES(ruta_imagen)
        ");
        $stmt->execute([
            ':codigo_generico' => $codigoGenerico,
            ':ruta_imagen' => $rutaBD
        ]);

        echo "✅ Imagen subida y guardada correctamente.";
    } else {
        echo "❌ Error al subir la imagen.";
    }

    $database->closeConnection();
} else {
    echo "❌ Error: Datos insuficientes.";
}
?>
