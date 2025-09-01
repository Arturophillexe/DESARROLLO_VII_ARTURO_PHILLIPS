<?php
// Ejemplo de uso de count()
$frutas = ["Manzana", "Naranja", "Plátano", "Uva", "Pera"];
$numFrutas = count($frutas);

echo "Array de frutas:</br>";
print_r($frutas);
echo "Número de frutas: $numFrutas</br>";

$misCanciones = ["carabali - mini all stars","garota de ipamena - antonio carlos jobim","master of puppets - metalica"]; // Reemplaza esto con tu array de canciones
$numCanciones = count($misCanciones);

echo "</br>Número de canciones en mi lista: $numCanciones</br>";

// Bonus: Usa count() con un array multidimensional
$playlist = [
    "Rock" => ["Bohemian Rhapsody", "Stairway to Heaven"],
    "Pop" => ["Thriller", "Billie Jean", "Beat It"],
    "Jazz" => ["Take Five", "So What"],
    "electro" => ["cinema","skrillex"],
    "afrobeat" => ["sabanaxua","studio bros"],
    "salsa" => ["me tengo que ir","orquesta los adolecentes"]
];

$totalCanciones = 0;
foreach ($playlist as $genero => $canciones) {
    $numCancionesGenero = count($canciones);
    $totalCanciones += $numCancionesGenero;
    echo "Canciones de $genero: $numCancionesGenero</br>";
}

echo "Total de canciones en la playlist: $totalCanciones</br>";
?>