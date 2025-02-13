<?php
require_once '../../database/Database.php';
require '../../../vendor/autoload.php'; // Cargar PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

set_time_limit(300);

$db = new Database();
$conn = $db->getConnection();

// Crear un nuevo archivo de Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Definir encabezados
$headers = ["codigo", "razon_social", "vendedor", "telefono"];
$sheet->fromArray([$headers], NULL, 'A1');

// Consulta SQL para obtener clientes con teléfono vacío o menos de 10 caracteres
$query = "SELECT codigo, razon_social, vendedor, telefono FROM clientes WHERE telefono = '' OR telefono IS NULL OR LENGTH(telefono) < 10";
$stmt = $conn->prepare($query);
$stmt->execute();

// Agregar datos a la hoja de cálculo
$rowNum = 2;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $sheet->fromArray([$row], NULL, 'A' . $rowNum);
    $rowNum++;
}

// Configurar encabezados para la descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="clientes_sin_telefono.xlsx"');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
