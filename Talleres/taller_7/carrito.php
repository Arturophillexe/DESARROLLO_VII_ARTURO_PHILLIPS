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
        
        <?php foreach ($carrito as $id => $item): 
            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;
        ?>
        <h3>Recibo</h3>
        <label for="product nombre">producto</label>
            <?= htmlspecialchars($item['nombre']) ?>
            <p>................................</p>
            <label for="precio">precio neto</label>
            $<?= $item['precio'] ?>
            <p>...........</p>
            <label for="cantidad">cantidad</label>
            <?= $item['cantidad'] ?>
            <label for="subtotal">---- subtotal:</label>
            $<?= $subtotal ?><br>
            <a href="carrito_rm.php?id=<?= $id ?>">Eliminar</a><br><br>

        <?php endforeach; ?>
    <p><strong>Total: $<?= $total ?></strong></p>
    <a href="checkout.php">Finalizar compra</a>
<?php 
endif;?>
<a href="productos.php">Volver a productos</a>
