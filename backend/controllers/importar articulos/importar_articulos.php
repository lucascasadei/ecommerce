<?php
require '../../../vendor/autoload.php';
require_once '../../database/Database.php'; // Incluir la conexión a la BD


use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportarExcel {
    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function importar($archivo) {
        try {
            ini_set('max_execution_time', 600);
            ini_set('memory_limit', '512M');

            $spreadsheet = IOFactory::load($archivo);
            $hoja = $spreadsheet->getActiveSheet();
            $datos = $hoja->toArray(null, true, true, true);

            array_shift($datos); // Eliminar encabezados

            echo "🔍 Total de filas en el Excel: " . count($datos) . "<br>";

            if (!is_dir('logs')) {
                mkdir('logs', 0777, true);
            }

            $sql = "INSERT INTO articulos (
                        codigo_generico, elemento1_codigo, elemento2_codigo, elemento3_codigo, 
                        descripcion, elemento1_nombre, elemento2_nombre, elemento3_nombre, 
                        ordenamiento1, ordenamiento2, proveedor_codigo, proveedor_nombre
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE 
                    descripcion = VALUES(descripcion), 
                    ordenamiento1 = VALUES(ordenamiento1), 
                    ordenamiento2 = VALUES(ordenamiento2), 
                    proveedor_nombre = VALUES(proveedor_nombre)";

            $stmt = $this->pdo->prepare($sql);
            $errores = [];
            $insertados = 0;
            $actualizados = 0;
            $fallidos = 0;

            foreach ($datos as $indice => $fila) {
                // Eliminar espacios en blanco del código generico
                $codigo_generico = isset($fila['A']) ? trim($fila['A']) : null;

                if ($indice < 10) {
                    echo "Fila {$indice}: Código Generico = '" . $codigo_generico . "'<br>";
                }

                if (empty($codigo_generico) || $codigo_generico == '0' || strlen($codigo_generico) < 3) {
                    $errores[] = "Fila {$indice}: Código inválido -> '" . $codigo_generico . "'";
                    $fallidos++;
                    continue;
                }

                try {
                    $stmt->execute([
                        $codigo_generico,
                        !empty($fila['B']) ? trim($fila['B']) : null,
                        !empty($fila['C']) ? trim($fila['C']) : null,
                        !empty($fila['D']) ? trim($fila['D']) : null,
                        trim($fila['E']),
                        !empty($fila['F']) ? trim($fila['F']) : null,
                        !empty($fila['G']) ? trim($fila['G']) : null,
                        !empty($fila['H']) ? trim($fila['H']) : null,
                        trim($fila['I']),
                        trim($fila['J']),
                        trim($fila['K']),
                        trim($fila['L'])
                    ]);

                    if ($stmt->rowCount() > 0) {
                        $insertados++;
                    } else {
                        $actualizados++;
                    }
                } catch (Exception $ex) {
                    $errores[] = "Fila {$indice}: " . $ex->getMessage();
                    $fallidos++;
                }
            }

            if (!empty($errores)) {
                file_put_contents('logs/errores_importacion.log', implode("\n", $errores));
                echo "⚠️ Hubo errores en algunas filas. Revisa el archivo 'logs/errores_importacion.log'.<br>";
            }

            echo "<br>✅ Total insertados: {$insertados}<br>";
            echo "🔄 Total actualizados: {$actualizados}<br>";
            echo "❌ Total fallidos: {$fallidos}<br>";

        } catch (Exception $e) {
            echo "❌ Error crítico al importar el archivo: " . $e->getMessage();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo_excel'])) {
    $archivo = $_FILES['archivo_excel']['tmp_name'];
    if ($archivo) {
        $importador = new ImportarExcel();
        $importador->importar($archivo);
    } else {
        echo "❌ No se ha subido ningún archivo.";
    }
}
?>

