<?php
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if ($data && is_array($data)) {
    function limpiar($valor) {
        $valor = preg_replace('/<script.*?>(.*?)<\/script>/is', '', $valor);

        return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
    }

    $usuario = limpiar($data['usuario'] ?? '');
    $clave = limpiar($data['clave'] ?? '');
    $edad = limpiar($data['edad'] ?? '');
    $tarjeta = limpiar($data['tarjeta'] ?? '');

    if (!is_numeric($edad) || intval($edad) <= 0) {
        http_response_code(400);
        echo "Edad inválida.";
        exit;
    }
    if (!preg_match('/^\d+$/', $tarjeta)) {
        http_response_code(400);
        echo "Número de tarjeta inválido.";
        exit;
    }

    $linea = "Usuario: $usuario, Contraseña: $clave, Edad: $edad, Tarjeta: $tarjeta\n";

    // Guardar los datos en el archivo
    $archivo = fopen("datos_guardados.txt", "a");
    if ($archivo) {
        fwrite($archivo, $linea);
        fclose($archivo);
        echo "Datos guardados correctamente.";
    } else {
        http_response_code(500);
        echo "No se pudo abrir el archivo.";
    }
} else {
    http_response_code(400);
    echo "Datos inválidos.";
}
?>
