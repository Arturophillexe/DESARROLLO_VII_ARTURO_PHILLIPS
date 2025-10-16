<?php session_start(); 
require 'cargar_productos.php'; ?>
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
$c=1;?>
<form action="al_carrito.php" method="post">
        <?php foreach ($inventario as $id => $producto): ?>
        <label for="nombre producto">
            <?= htmlspecialchars($producto['nombre']) ?></label></n>
            <label for="producto precio"><?= $producto['precio'] ?></label><br>
            <label for="producto descrp"><?= $producto['descripcion'] ?></label><br>
            <label for="cantidad">cantidad</label>
                <input type="number" name="cantidad[<?= $id ?>]" value="1" min="1">
                <input type="hidden" name="id[]" value="<?= $id ?>"><br>

                <button type="submit" name="agregar" value="<?= $id ?>">Añadir al carrito</button><br><br>z
            
        
        <?php endforeach; ?>
</form>
</body>
</html>