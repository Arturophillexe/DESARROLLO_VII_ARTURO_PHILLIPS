<?php
session_start();
$id = (int) $_GET['id'];
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}
if (isset($_SESSION['carrito'][$id])) {
    $_SESSION['carrito'][$id]['cantidad']++;
} else {
    // Aquí deberías validar que el producto existe
    $productos = json_decode("productos.json",true);
    if (isset($productos[$id])) {
        $_SESSION['carrito'][$id] = [
            'nombre' => $productos[$id]['nombre'],
            'precio' => $productos[$id]['precio'],
            'cantidad' => 1
        ];
    }
}
header('Location: carrito.php');
