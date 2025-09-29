<?php
// 1. Crear un arreglo multidimensional de ventas por región y producto
$ventas = [
    "Norte" => [
        "Producto A" => [100, 120, 140, 110, 130],
        "Producto B" => [85, 95, 105, 90, 100],
        "Producto C" => [60, 55, 65, 70, 75]
    ],
    "Sur" => [
        "Producto A" => [80, 90, 100, 85, 95],
        "Producto B" => [120, 110, 115, 125, 130],
        "Producto C" => [70, 75, 80, 65, 60]
    ],
    "Este" => [
        "Producto A" => [110, 115, 120, 105, 125],
        "Producto B" => [95, 100, 90, 105, 110],
        "Producto C" => [50, 60, 55, 65, 70]
    ],
    "Oeste" => [
        "Producto A" => [90, 85, 95, 100, 105],
        "Producto B" => [105, 110, 100, 115, 120],
        "Producto C" => [80, 85, 75, 70, 90]
    ]
];

// 2. Función para calcular el promedio de ventas
function promedioVentas($ventas) {
    return array_sum($ventas) / count($ventas);
}

// 3. Calcular y mostrar el promedio de ventas por región y producto
echo "Promedio de ventas por región y producto:\n";
foreach ($ventas as $region => $productos) {
    echo "$region:\n";
    foreach ($productos as $producto => $ventasProducto) {
        $promedio = promedioVentas($ventasProducto);
        echo "  $producto: " . number_format($promedio, 2) . "\n";
    }
    echo "\n";
}

// 4. Función para encontrar el producto más vendido en una región
function productoMasVendido($productos) {
    $maxVentas = 0;
    $productoTop = '';
    foreach ($productos as $producto => $ventas) {
        $totalVentas = array_sum($ventas);
        if ($totalVentas > $maxVentas) {
            $maxVentas = $totalVentas;
            $productoTop = $producto;
        }
    }
    return [$productoTop, $maxVentas];
}

// 5. Encontrar y mostrar el producto más vendido por región
echo "Producto más vendido por región:\n";
foreach ($ventas as $region => $productos) {
    [$productoTop, $ventasTop] = productoMasVendido($productos);
    echo "$region: $productoTop (Total: $ventasTop)\n";
}

// 6. Calcular las ventas totales por producto
$ventasTotalesPorProducto = [];
foreach ($ventas as $region => $productos) {
    foreach ($productos as $producto => $ventasProducto) {
        if (!isset($ventasTotalesPorProducto[$producto])) {
            $ventasTotalesPorProducto[$producto] = 0;
        }
        $ventasTotalesPorProducto[$producto] += array_sum($ventasProducto);
    }
}

echo "\nVentas totales por producto:\n";
arsort($ventasTotalesPorProducto);
foreach ($ventasTotalesPorProducto as $producto => $total) {
    echo "$producto: $total\n";
}

// 7. Encontrar la región con mayores ventas totales
$ventasTotalesPorRegion = array_map(function($productos) {
    return array_sum(array_map('array_sum', $productos));
}, $ventas);

$regionTopVentas = array_keys($ventasTotalesPorRegion, max($ventasTotalesPorRegion))[0];
echo "\nRegión con mayores ventas totales: $regionTopVentas\n";

// TAREA: Implementa una función que analice el crecimiento de ventas
// Calcula y muestra el porcentaje de crecimiento de ventas del primer al último mes
// para cada producto en cada región. Identifica el producto y la región con mayor crecimiento.
// Tu código aquí
function analizaCrecimientoVenta($ventas)
{
    if (empty($ventas)){return
        [
            'crecimiento_detallado' => [],
            'mayor_crecimiento' => [,
                'producto' => null,
                'region' => null,
                'porcentaje' => 0]
        ];}
    $ventasgrupo = [];
    foreach ($ventas as $venta) {
        $region = $venta['region'];
        $producto = $venta['producto_id'];
        $mes = date('Y-m', strtotime($venta['fecha']));
        $monto = $venta['monto'];
}
if (!isset($ventasAgrupadas[$region])) {
            $ventasAgrupadas[$region] = [];
        }
        if (!isset($ventasAgrupadas[$region][$producto])) {
            $ventasAgrupadas[$region][$producto] = [];
        }
        if (!isset($ventasAgrupadas[$region][$producto][$mes])) {
            $ventasAgrupadas[$region][$producto][$mes] = 0;
        }

        $ventasAgrupadas[$region][$producto][$mes] += $monto;
    }
    $reporteCrecimiento = [];
    $maxCrecimiento = -INF; // Usamos -infinito para asegurar que cualquier crecimiento sea mayor
    $mejorProducto = null;
    $mejorRegion = null;

    foreach ($ventasAgrupadas as $region => $productos) {
        $reporteCrecimiento[$region] = [];
        foreach ($productos as $productoId => $ventasMensuales) {
             ksort($ventasMensuales);
              if (count($ventasMensuales) < 2) {
                $reporteCrecimiento[$region][$productoId] = 'Datos insuficientes';
                continue;
            }
            $primerMes = array_key_first($ventasMensuales);
            $ultimoMes = array_key_last($ventasMensuales);

            $ventaInicial = $ventasMensuales[$primerMes];
            $ventaFinal = $ventasMensuales[$ultimoMes];

            $crecimiento = 0;
            if ($ventaInicial > 0) {
                $crecimiento = (($ventaFinal - $ventaInicial) / $ventaInicial) * 100;
            } elseif ($ventaFinal > 0) {$crecimiento = INF;
            }
            $reporteCrecimiento[$region][$productoId] = $crecimiento;
            if ($crecimiento > $maxCrecimiento) {
                $maxCrecimiento = $crecimiento;
                $mejorProducto = $productoId;
                $mejorRegion = $region;
            }
        }
         return [
        'crecimiento_detallado' => $reporteCrecimiento,
        'mayor_crecimiento' => [
            'producto' => $mejorProducto,
            'region' => $mejorRegion,
            'porcentaje' => $maxCrecimiento
        ]
    ];
        }
print_r(analizaCrecimientoVenta($ventas));
?>