<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="../../backend/controllers/importar_precios/importar_precios.php" method="POST" enctype="multipart/form-data">
    <label for="archivo_excel">Seleccionar archivo Excel:</label>
    <input type="file" name="archivo_excel" accept=".xlsx, .xls, .csv" required>
    <button type="submit">Actualizar Precios</button>
</form>

</body>
</html>