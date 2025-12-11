<?php
require_once '../../config.php';
use Src\Comunidad\publicacionmanager;

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../registro/views/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_SESSION['usuario_id'];
    $contenido = htmlspecialchars($_POST['contenido']);
    $imagenNombre = null;

    
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $directorioDestino = __DIR__ . '/../../public/uploads/'; 
        
        
        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $imagenNombre = uniqid('post_') . '.' . $extension;
        
        
        $tiposPermitidos = ['jpg', 'jpeg', 'png'];
        if (in_array(strtolower($extension), $tiposPermitidos)) {
            move_uploaded_file($_FILES['imagen']['tmp_name'], $directorioDestino . $imagenNombre);
        } else {
            $imagenNombre = null; 
        }
    }

    
    $publicacion = new publicacionmanager($db);
    $publicacion->crearPost($usuario_id, $contenido, $imagenNombre);

   
    header("Location: ../views/feed.php");
    exit;
}