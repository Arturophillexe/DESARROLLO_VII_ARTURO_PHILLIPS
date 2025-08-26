<?php
$nombre = "arturo phillips";
$edad = 25;
$correo = "arturo.phillips@utp.ac.pa";
$telefono = "6219-2111";
define("OCUPACION", "estudiante de la Facultad de FISC");

echo "buenas, soy $nombre, y con $edad años, mi correo de universitario es $correo,  y obviamente mi ocupacion es ". OCUPACION . ".<br>";

print("<br> Debugging Info <br>");
var_dump($nombre);
echo "<br>";
var_dump($edad);
echo "<br>";
var_dump($correo);
echo "<br>";
var_dump($telefono);
echo "<br>";
var_dump(OCUPACION);
echo "<br>";


?>