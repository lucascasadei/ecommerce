<?php
require '../../vendor/autoload.php'; // Cargar PhpSpreadsheet
require '../../backend/database/Database.php'; // Cargar conexión a la base de datos

use PhpOffice\PhpSpreadsheet\IOFactory;

// Instanciar la conexión con la base de datos
$database = new Database();
$pdo = $database->getConnection();

// Ruta del archivo Excel (ajustar según ubicación)
$archivoExcel = __DIR__ . '/clientes.xlsx';

// Cargar el archivo Excel
$spreadsheet = IOFactory::load($archivoExcel);
$hoja = $spreadsheet->getActiveSheet();
$datos = $hoja->toArray(null, true, true, true);

// Recorrer las filas del archivo e insertar en la base de datos
foreach ($datos as $index => $fila) {
    if ($index == 1) continue; // Omitir encabezados

    $sql = "INSERT INTO clientes (vendedor, zona, codigo, tipo_cliente, razon_social, contacto_email, nombre_fantasia, tipo_documento, situacion_iva, numero_documento, direccion, localidad, provincia, telefono, email, vendedor_codigo) 
            VALUES (:vendedor, :zona, :codigo, :tipo_cliente, :razon_social, :contacto_email, :nombre_fantasia, :tipo_documento, :situacion_iva, :numero_documento, :direccion, :localidad, :provincia, :telefono, :email, :vendedor_codigo)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':vendedor' => $fila['A'],
        ':zona' => $fila['B'],
        ':codigo' => $fila['C'],
        ':tipo_cliente' => $fila['D'],
        ':razon_social' => $fila['E'],
        ':contacto_email' => $fila['F'],
        ':nombre_fantasia' => $fila['G'],
        ':tipo_documento' => $fila['H'],
        ':situacion_iva' => $fila['I'],
        ':numero_documento' => $fila['J'],
        ':direccion' => $fila['K'],
        ':localidad' => $fila['L'],
        ':provincia' => $fila['M'],
        ':telefono' => $fila['N'],
        ':email' => $fila['O'],
        ':vendedor_codigo' => $fila['P'],
    ]);
}

echo "Importación completada correctamente.";

// Cerrar conexión
$database->closeConnection();
?>
