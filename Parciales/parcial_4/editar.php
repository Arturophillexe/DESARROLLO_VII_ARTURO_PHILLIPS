<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar producto</title>
</head>
<body>
    <form action="funciones.php?accion=editar" method="post">
        <p>con el id de su producto modifique lo que desee</p><br>

        <label for="id">el id a buscar</label>
        <input type="number"><br>
        <label for="nombre">nombre nuevo</label>
        <input type="text"><br>
        <label for="categoria">categoria nueva</label>
        <input type="text"><br>
        <label for="precio">precio nuevo</label>
        <input type="number" step="2" placeholder="00.00">><br>
        <label for="cantidad">cantidad nueva</label>
        <input type="number"><br><br>

        <button type="submit">hacer cambios</button>
    </form>
    <a href="index.php">volver</a>
</body>
</html>