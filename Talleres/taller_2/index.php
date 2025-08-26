<?php
$nombre ="juan";
$edad = 25;
$altura = 1.80;
$esEstudiante = true;

echo "hello world";
echo "nombre: $nombre<br>";
echo "edad: $edad<br>";
echo "altura: $altura<br>";
echo "es estudiante? ". ($esEstudiante ? "si" : "no")."<br>";

$presentacion1 = "hola, mi nombre es ". $nombre . "y tengo ". $edad ." años";
$presentacion2 = "hola, soy $nombre y tengo $edad años";

define ("Saludo", "Bienvenido");

$mensaje = Saludo . " ". $nombre;

echo $presentacion1."<br>";
echo $presentacion2."<br>";
echo $mensaje."<br>";
?>