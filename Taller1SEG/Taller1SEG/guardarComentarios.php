<?php
$usuario = $_POST['usuario'];
$comentario = $_POST['comentario'];

// Se guarda sin limpiar el contenido (vulnerable)
$linea = "<p><strong>$usuario:</strong> $comentario</p>\n";
file_put_contents("comentarios.txt", $linea, FILE_APPEND);


header("Location: PaginaSinProteccion.php");
?>