<?php
// Ejemplo de uso de explode()
$frase = "tralalero,tung_tung,ballerina,bombardiro";
$frutas = explode(",", $frase);

echo "Frase original: $frase</br>";
echo "Array de frutas:</br>";
print_r($frutas);


$misPeliculas = "viernes_13-el_resplandor-pesadilla_de_la_calle_elm-el_conjuro";
$arrayPeliculas = explode("-", $misPeliculas);

echo "</br>Mis películas favoritas:</br>";
print_r($arrayPeliculas);


$texto = "mario,sonic,pikachu,samus,link";
$array = explode(",", $texto, 3);

echo "</br>Texto original: $texto</br>";
echo "Array con límite:</br>";
print_r($array);
?>