<?php 
$frase = "el perro naranja jugo con la oveja naranja";
$modificada = str_replace("naranja","blanco",$frase);

echo "$frase. es lo original pero <br>.";
echo "$modificada. esta modificada";

$miFrase ="la gente vive la vida al vivirla";
$miModify=str_replace("vivirla","no trabajar",$miFrase);
echo "no confundir $miFrase,"."<br>". "con $miModify.";


$texto = "Manzanas y naranjas son frutas. Me gustan las manzanas y las naranjas.";
$buscar = ["Manzanas", "naranjas"];
$reemplazar = ["Peras", "uvas"];
$textoModificado = str_replace($buscar, $reemplazar, $texto);

echo "</br>Texto original: $texto</br>";
echo "Texto modificado: $textoModificado</br>";
?>
?>