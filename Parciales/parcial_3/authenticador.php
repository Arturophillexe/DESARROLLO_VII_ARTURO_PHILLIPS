<?php
require_once "array_user.php";
$user = $_POST["user"];

foreach($registro as $usuario => $tipo) {
 if ($tipo['nombre'] == $user) {
        $rol = $tipo['rol'];
        break;
 }
}

session_start();
$_SESSION['usuario'] = $user;
$_SESSION['rol'] = $rol;

if ($_SESSION['rol'] == "estudiante") {
    header("Location: estudiante/estudiante.php");
    exit;
} elseif ($_SESSION['rol'] == "profesor") {
    header("Location: profesor/profesor.php");
    exit;
} else {
    echo 'Sucedió un problema <a href="../index.php">volver</a>';
}
?>
