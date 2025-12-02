<?php
include 'funciones.php';
$paginas = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$productos = listar_productos($conn,$paginas,10)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>techparts</title>
</head>
<body>
    <table>
        <tr>
            <th>nombre</th>
            <th>categoria</th>
            <th>precio</th>
            <th>cantidad</th>
        </tr>
            <?php foreach ($productos as $producto) 
                echo "<tr>";
            echo "<td>".$producto['nombre']."</td>";
            echo "<td>".$producto['categoria']."</td>";
            echo "<td>".$producto['precio']."</td>";
            echo "<td>".$producto['cantidad']."</td>";
                echo"</tr>"
            ?>
    <a href="crear.php">crear un nuevo producto</a>
    <a href="editar.php">editar un producto</a>
    <a href="eliminar.php">eliminar un producto</a>
    </table>
</body>
</html>
