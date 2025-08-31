<?php
//paso 2
$nombre = "luis miguel";
$longitud = strlen($nombre);

echo "el nombre $nombre tiene ".$longitud." caracteres.";

$miNombre = "Arturo Alberto Phillips Lemus";
$miLongitud = strlen($miNombre);

echo "mi nombre tiene $miLongitud caracteres de largo.";

function categorizarLongitud($text){
    $longitud = strlen($text);
    if($longitud < 5)
        return "corto";
    elseif ($longitud <= 10)
        return "medio";
    else
        return "largo";
}

$category = categorizarLongitud($miNombre);
echo "<br>Mi nombre es considerado $category.";
?>