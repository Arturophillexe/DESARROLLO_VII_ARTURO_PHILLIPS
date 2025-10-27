<?php
require_once "config.php";
function registro_usuario($conn,$nombre,$email,$contrasena)
{
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre,email,contrasena) VALUES (?, ?, ?)");
    if(!$stmt)throw new Exception("vaya, fallo en preparacion: ".$conn->error);
    
    $nombre = sanitizar($nombre);
    $email = filter_var($email,FILTER_SANITIZE_EMAIL);
    $contrasenaH = password_hash($contrasena,PASSWORD_DEFAULT);
    $stmt->bind_param("sss", $nombre, $email, $contrasenaH);
    if (!$stmt->execute()) throw new Exception("error insertando el nuevo usuario");
    $stmt->close();
}
function listar_usuarios($conn, $lista=1,$limite=10){
    $offset = ($lista - 1) * $limite;
    $stmt = $conn->prepare("SELECT id, nombre, email FROM usuarios LIMIT ?, ?");
    $stmt->bind_param("ii", $offset, $limite);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuarios = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $usuarios;}
function buscar_usuario($conn, $criterio, $valor) {
    $valor = "%" . sanitizar($valor) . "%";
    $query = "SELECT id, nombre, email FROM usuarios WHERE $criterio LIKE ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $valor);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuarios = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $usuarios;}
function actualizar_usuario($conn, $id, $datos) {
    $stmt = $conn->prepare("UPDATE usuarios SET nombre=?, email=?, password=? WHERE id=?");
    $nombre = sanitizar($datos['nombre']);
    $email = filter_var($datos['email'], FILTER_SANITIZE_EMAIL);
    $passwordHash = password_hash($datos['password'], PASSWORD_DEFAULT);
    $stmt->bind_param("sssi", $nombre, $email, $passwordHash, $id);
    if (!$stmt->execute()) throw new Exception("Error al actualizar usuario: " . $stmt->error);
    $stmt->close();
}
function eliminar_usuario($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id=?");
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) throw new Exception("Error al eliminar usuario: " . $stmt->error);
    $stmt->close();}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>usuarios</title>
</head>
<header><h1>bienvenido, que desea hacer?</h1></header>
<body>
    <h2>Añadir usuario</h2>
    <form action="usuarios.php?accion=añadir" method="POST">
        <input type="text" name="nombre" placeholder="su nombre" required>
        <input type="email" name="email" placeholder="ejemplo@dominio.com" required>
        <input type="password" name="contrasena" placeholder="contraseña" required>
        <button type="submit">Añadir</button>
    </form>

    <h2>listar usuarios</h2>
    <form action="usuarios.php" method="GET">
        <select name="criterio">
            <option value="nombre">nombre</option>
            <option value="email">email</option>
        </select>
        <input type="text" name="valor" placeholder="Buscar...">
        <input type="hidden" name="accion" value="buscar">
        <button type="submit">Buscar</button>
    </form>

    <h2>Actualizar usuario</h2>
    <form action="usuarios.php?accion=actualizar" method="POST">
        <input type="number" name="id" placeholder="ID de usuario" required>
        <input type="text" name="nombre" placeholder="Nuevo nombre" required>
        <input type="email" name="email" placeholder="Nuevo email" required>
        <input type="text" name="contrasena" placeholder="Nueva contraseña" required>
        <button type="submit">Actualizar</button>
    </form>

    <h2>Eliminar usuario</h2>
    <form action="usuarios.php" method="GET">
        <input type="number" name="id" placeholder="ID del usuario a eliminar" required>
        <input type="hidden" name="accion" value="eliminar">
        <button type="submit">Eliminar</button>
    </form>
    <?php
    $accion = isset($_GET['accion']) ? $_GET['accion'] : 'listar';

try {
    switch ($accion) {
        case 'añadir':
            registro_usuario($conn, $_POST['nombre'],$_POST['email'],$_POST['contrasena']);
            echo "usuario añadido correctamente.";
            break;

        case 'listar':
            $pagina = isset($_GET['nombre']) ? (int)$_GET['email'] : 1;
            $user = listar_usuarios($conn, $pagina, 10);
            foreach ($user as $usuario) {
                echo "<p>{$usuario['nombre']} - {$usuario['email']} </p>";
            }
            break;

        case 'buscar':
            $criterio = $_GET['criterio'] ?? 'titulo';
            $valor = $_GET['valor'] ?? '';
            $resultados = buscar_usuario($conn, $criterio, $valor);
            foreach ($resultados as $usuario) {
                echo "<p> {$usuario['nombre']} - {$usuario['email']}</p>";
            }
            break;

        case 'actualizar':
            $id = (int)$_POST['id'];
            $datos = [
                'nombre' => $_POST['nombre'],
                'email' => $_POST['email'],
                'contrasena' => $_POST['contrasena'],
            ];
            actualizar_usuario($conn, $id, $datos);
            echo " usuario actualizado.";
            break;

        case 'eliminar':
            $id = (int)$_GET['id'];
            eliminar_usuario($conn, $id);
            echo " usuario eliminado.";
            break;

        default:
            echo " Acción no reconocida.";
            break;
    }
} catch (Exception $e) {
    echo " Error: " . $e->getMessage();
}
?>
   <a href="index.php">regresar</a>
</body>
</html>