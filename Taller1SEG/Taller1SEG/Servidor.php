<?php
if (isset($_POST['datos'])) {
    $archivo = fopen("datos.txt", "a");
    fwrite($archivo, $_POST['datos'] . "\n");
    fclose($archivo);
}
?>