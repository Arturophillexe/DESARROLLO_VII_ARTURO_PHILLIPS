<?php
// Ejemplo de uso de implode()
$frutas = ["tripi_tropi", "lirili_larila", "turip_turip", "capucinni"];
$frase = implode(", ", $frutas);

echo "Array de brainrot:</br>";
print_r($frutas);
echo "Frase creada: $frase</br>";


$paises = ["alemania","japon","buddapest","singapour","costa_rica"]; // Reemplaza esto con tu array de países
$listaPaises = implode("-", $paises);

echo "</br>Mi lista de países para visitar: $listaPaises</br>";

// Bonus: Usa implode() con un array asociativo
$persona = [
    "nombre" => "Juan",
    "edad" => 30,
    "ciudad" => "Madrid",
    "telefono" => "6060-1234",
    "ocupacion" => "jefe de sistemas"
];
$infoPersona = implode(" | ", $persona);

echo "</br>Información de la persona: $infoPersona</br>";
?>