<?php 
$calificacion = 53;

if ($calificacion >= 0 && $calificacion<60){$letra = "F";}  
elseif($calificacion>=60 && $calificacion<70){$letra = "D";}
elseif($calificacion>=70 && $calificacion<80){$letra = "C";}
elseif($calificacion>=80 && $calificacion<90){$letra = "B";}
elseif($calificacion>=90 && $calificacion<=100){$letra = "A";}
    

$aprobacion = ($letra !== "F") ? "Aprobado,":"Reprobado,";

switch ($letra){
case "F":
    $admensaje="debes esforsarte mas";
    break;
case "D":
    $admensaje="nesesitas mejorar";
    break;
case "C":
    $admensaje="Trabajo aceptable";
    break;
case "B":
    $admensaje="Buen Trabajo";
    break;
case "A":
    $admensaje="Exelente trabajo";
    break;
}

echo "tu Calificacion es: ".$letra."<br>".$aprobacion." ".$admensaje;
?>