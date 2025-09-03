<?php
// primero busqueda del archivo
$json_data = file_get_contents('inventario.json');
$inventory = json_decode($json_data, true);
//ordena en orden alfabetico
usort($inventory, function($a, $b) {
    return strcmp($a['nombre'], $b['nombre']);
});

echo "<h1>Resumen del Inventario</h1>";
echo "<ul>";
foreach ($inventory as $item) {
    echo "<li>" . $item['nombre'] . ": " . $item['cantidad'] . " unidades a $" . $item['precio'] . " cada una.</li>";
}
echo "</ul>";

$item_prices = array_map(function($item) {
    return $item['precio'] * $item['cantidad'];
}, $inventory);

$total_price = array_sum($item_prices);

echo "<h2>Precio Total del Inventario: $" . number_format($total_price, 2) . "</h2>";

$low_stock_products = array_filter($inventory, function($item) {
    return $item['cantidad'] < 10;
});

echo "<h2>Reporte de Productos con Bajo Stock</h2>";
echo "<ul>";
foreach ($low_stock_products as $item) {
    echo "<li>" . $item['nombre'] . ": " . $item['cantidad'] . " unidades restantes.</li>";
}
echo "</ul>";

?>