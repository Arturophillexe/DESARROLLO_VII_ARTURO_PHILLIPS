<?php
session_start();
$carrito = $_SESSION['carrito'] ?? [];
$total = 0;
foreach ($carrito as $item) {
    $total += $item['precio'] * $item['cantidad'];
}
setcookie('usuario', 'Arturo', time() + 86400); 
$_SESSION['carrito'] = []; 
?>

<h2>Resumen de compra</h2>
<?php if ($total > 0): ?>
    <p>Gracias por tu compra, <?= htmlspecialchars($_COOKIE['usuario'] ?? 'Usuario') ?>.</p>
    <p>Total pagado: $<?= $total ?></p>
<?php else: ?>
    <p>No hay productos en el carrito.</p>
<?php endif; ?>
<a href="productos.php">Volver a la tienda</a>
