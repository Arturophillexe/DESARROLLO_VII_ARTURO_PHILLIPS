<?php
session_start();
$carrito = $_SESSION['carrito'] ?? [];
$total = 0;
?>

<h2>Tu carrito</h2>
<?php if (empty($carrito)): ?>
    <p>El carrito está vacío.</p>
<?php else: ?>
    <table border="1">
        <tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th><th>Acción</th></tr>
        <?php foreach ($carrito as $id => $item): 
            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;
        ?>
        <tr>
            <td><?= htmlspecialchars($item['nombre']) ?></td>
            <td>$<?= $item['precio'] ?></td>
            <td><?= $item['cantidad'] ?></td>
            <td>$<?= $subtotal ?></td>
            <td><a href="carrito_rm.php?id=<?= $id ?>">Eliminar</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p><strong>Total: $<?= $total ?></strong></p>
    <a href="checkout.php">Finalizar compra</a>
<?php endif; ?>
<a href="productos.php">Volver a productos</a>
