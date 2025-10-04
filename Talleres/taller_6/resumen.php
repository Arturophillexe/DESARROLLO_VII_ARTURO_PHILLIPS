<?php
$archivo = 'registros.json';

if (!file_exists($archivo)) {
    echo "<p>No hay registros aún.</p>";
    echo "<br><a href='formulario.php'>Volver al formulario</a>";
    exit;
}

$registros = json_decode(file_get_contents($archivo), true);

echo "<h2>Resumen de registros</h2>";
echo "<pre>" . json_encode($registros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
echo "<br><a href='formulario.php'>Volver al formulario</a>";
?>
