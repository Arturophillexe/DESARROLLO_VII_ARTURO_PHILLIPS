<!---este archivo cuenta como paso 1 y 2 --> 
<?php
//paso 3
$nombre ="juan";
$edad = 25;
$altura = 1.80;
$esEstudiante = true;

echo "hello world";
echo "nombre: $nombre<br>";
echo "edad: $edad<br>";
echo "altura: $altura<br>";
echo "es estudiante? ". ($esEstudiante ? "si" : "no")."<br>";
//paso 4
$presentacion1 = "hola, mi nombre es ". $nombre . "y tengo ". $edad ." años";
$presentacion2 = "hola, soy $nombre y tengo $edad años";

define ("Saludo", "Bienvenido");

$mensaje = Saludo . " ". $nombre;

echo $presentacion1."<br>";
echo $presentacion2."<br>";
echo $mensaje."<br>";
//paso 5
$nombre2 = "maria";
$edad2 = 22 ;
echo "Hola, mundo!<br>";
echo "Mi nombre es $nombre2 <br>";

print "Tengo $edad2 años<br>";

printf("Me llamo %s y tengo %d años<br>", $nombre2, $edad2);

var_dump($nombre2);
echo "<br>";

//paso 6 ejercicio practico
$nombre3 = "mauricio";
$edad3 = 32;
$ciudad = "mumbai";

define ("Profecion","Ingeniero industrial");

$mensaje1 = "नमस्ते, mi nombre es " . $nombre3 . "y tengo ". $edad3. "años.";
$mensaje2 ="Vivo en $ciudad y Soy ". Profecion . ".";

echo $mensaje1. "<br>";
print($mensaje2. "<br>");

echo "<br> Informacion de debbuging: <br>";
var_dump($nombre);
echo "<br>";
var_dump($edad);
echo "<br>";
var_dump($ciudad);
echo "<br>";
var_dump(Profecion);
echo "<br>";
?>