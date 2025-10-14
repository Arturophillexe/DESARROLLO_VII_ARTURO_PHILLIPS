<?php
session_start();
$id = (int) $_GET['id'];
if (isset($_SESSION['carrito'][$id])) {
    unset($_SESSION['carrito'][$id]);
}
header('Location: carrito.php');
