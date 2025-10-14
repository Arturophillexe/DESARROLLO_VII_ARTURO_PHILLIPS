<?php require 'cargar_productos.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda el poder</title>
</head>
<body>
<h2>precios baratitos</h2>

<a href="carrito.php">su carrito</a>
   <?php

$inventario = cargarProductos();
$c=1;
echo '<form action="al_carrito.php" method="post">';
foreach($inventario as $id => $obj){
    echo '    
    <label for="objeto'.$c.'">'.$obj["nombre"].':</label>
    <label for="descr'.$c.'"> '.$obj["descripcion"].'</label><br>
    <label for="descr'.$c.'"> '.$obj["precio"].'</label><br>
    <label for="cantidad">cantidad</label>
    <input type="number" name="cantidad" ><br><br>';
}
echo '<button type="submit">al carrito</button>';
?>
</body>
</html>