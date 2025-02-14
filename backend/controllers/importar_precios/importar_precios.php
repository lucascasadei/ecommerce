<?php
require_once '../../database/Database.php';
require '../../../vendor/autoload.php'; // Necesitas PHPSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo_excel'])) {
    $database = new Database();
    $pdo = $database->getConnection();

    $archivo = $_FILES['archivo_excel']['tmp_name'];

    try {
        $spreadsheet = IOFactory::load($archivo);
        $hoja = $spreadsheet->getActiveSheet();
        $filas = $hoja->toArray();

        // Iterar sobre las filas (desde la segunda porque la primera es el encabezado)
        foreach ($filas as $index => $fila) {
            if ($index == 0) continue; // Saltar encabezado

            $codigo_generico = trim($fila[0]); // Columna "Artículo - Cód. Genérico"
            $precio = str_replace(',', '.', $fila[2]); // Columna "Precio" (cambiar ',' por '.')

            if (!empty($codigo_generico) && is_numeric($precio)) {
                $stmt = $pdo->prepare("UPDATE articulos SET precio = :precio WHERE codigo_generico = :codigo");
                $stmt->bindParam(":precio", $precio, PDO::PARAM_STR);
                $stmt->bindParam(":codigo", $codigo_generico, PDO::PARAM_STR);
                $stmt->execute();
            }
        }

        echo "✅ Precios actualizados correctamente.";
    } catch (Exception $e) {
        echo "❌ Error al procesar el archivo: " . $e->getMessage();
    }

    $database->closeConnection();
} else {
    echo "❌ No se ha subido un archivo.";
}
?>
