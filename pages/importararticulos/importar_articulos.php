<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar Excel</title>
</head>
<body>
    <h2>Subir Archivo Excel</h2>
    <form action="../../backend/controllers/importar articulos/importar_articulos.php" method="post" enctype="multipart/form-data">
        <input type="file" name="archivo_excel" accept=".xlsx, .xls" required>
        <button type="submit">Importar</button>
    </form>
</body>
</html>
