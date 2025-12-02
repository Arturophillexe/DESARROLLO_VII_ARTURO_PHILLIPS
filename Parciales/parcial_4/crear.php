<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto</title>
</head>
<body>
    <form action="funciones.php?accion=crear" method="post">
        <label for="nombre">nombre  
        </label><input type="text"><br>
        <label for="categoria"> categoria
        </label><input type="text"><br>
        <label for="precio">precio a añadir
        </label><input type="number" step="2" placeholder="00.00"><br>
        <label for="cantidad">cantidad a vender 
        </label><input type="number"><br><br>
        <button type="submit">añadir producto</button>
    </form>
    <a href="index.php">volver</a>
</body>
</html>