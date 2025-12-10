<?php
require_once BASE_PATH.'config.php'; 
use Src\Registro\Autenticacion;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $auth = new Autenticacion($db);
    $usuario_id = $auth->login($email, $password);

    if ($usuario_id) {
        // Login exitoso
        $_SESSION['usuario_id'] = $usuario_id;
        header("Location: ../../comunidad/views/feed.php");
        exit;
    } else {
        header("Location: ../views/login.php?error=credenciales_incorrectas");
        exit;
    }
}

?>