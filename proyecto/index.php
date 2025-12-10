
<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

// Define the base path for includes
define('BASE_PATH', __DIR__ . '/');

require_once  BASE_PATH.'config.php';


require_once BASE_PATH . 'src/usuarios/usuarios.php';
require_once BASE_PATH . 'src/interaccion/perfil.php';
require_once BASE_PATH . 'src/comunity/publicacion.php';
require_once BASE_PATH . 'src/interaccion/mensaje.php';
require_once BASE_PATH . 'src/comunity/amigos.php';



// Get the action from the URL, default to 'list' if not set
$action = $_GET['action'] ?? 'list';

header('location:'. BASE_URL .'src/views/layout.php');
switch ($action){
  case 'publicacion':
header('location: '. BASE_URL . 'src/comunity/publicacionmanager.php');
}

?>