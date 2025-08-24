
<?php
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if ($data && is_array($data)) {
    function limpiar($valor) {
        $valor = preg_replace('/<script.*?>(.*?)<\/script>/is', '', $valor);

        return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
    }

    $usuario = limpiar($data['usuario'] ?? '');
    $comentario = limpiar($data['comentario'] ?? '');



    $linea = "Usuario: $usuario, Comentario: $comentario\n";
    $linea = "<p><strong>$usuario:</strong> $comentario</p>\n";
file_put_contents("comentariosLimpios.txt", $linea, FILE_APPEND);

    // Guardar los datos en el archivo
 //   $archivo = fopen("comentariosLimpios.txt", "a");
    if ($linea) {
        fwrite( $linea);
        fclose($linea);
        echo "Datos guardados correctamente.";
    } else {
        http_response_code(500);
        echo "No se pudo abrir el archivo.";
    }
} else {
    http_response_code(400);
    echo "Datos inválidos.";
}
header("Location: PaginaLimpia.php");
?>
