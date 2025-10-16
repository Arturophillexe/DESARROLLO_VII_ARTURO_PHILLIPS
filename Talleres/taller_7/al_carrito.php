<?php
session_start();
require 'cargar_productos.php';
$productos = cargarProductos();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    $id = (int) $_POST['agregar'];
    $cantidad = isset($_POST['cantidad'][$id]) ? max(1, (int) $_POST['cantidad'][$id]) : 1;

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
    } elseif (isset($productos[$id])) {
        $_SESSION['carrito'][$id] = [
            'nombre' => $productos[$id]['nombre'],
            'precio' => $productos[$id]['precio'],
            'cantidad' => $cantidad
        ];
    }
}
header('Location: carrito.php');
