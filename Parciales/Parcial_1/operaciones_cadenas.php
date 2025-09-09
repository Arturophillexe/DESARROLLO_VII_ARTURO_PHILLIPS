<?php 
function contar_palabras_repetidoas($text){
    trim($text,"!"."?"."¡"."¿");
    $array = explode(",",$text);
    foreach ($array as $word) {
        $i=0;
        $wordcount = 1;
        if ($array[$i++] == $word){
        $wordcount++;
        }
        
    }
    
    return "el texto $text tinene los siguientes repetidos => <br>".strtolower($word)." => $wordcount";
}
function capitalizar_palabras($text){
}

?>