<?php
require_once "config.php";
function registro_usuario($pdo,$nombre,$email,$contrasena)
{
    $sql = "INSERT INTO usuarios (nombre,email,contrasena)
            VALUES (:nombre,:email,:contrasena)";
        $stmt = $pdo->prepare($sql);
        if(!$stmt)throw(new Exception("vaya, fallo en preparacion: ".$pdo->error));
        $stmt->execute([
            ':nombre'=>sanitizar($nombre),
            ':email'=>filter_var($email,FILTER_SANITIZE_EMAIL),
            ':contrasena'=> password_hash($contrasena,PASSWORD_DEFAULT)
        ]);
}
function listar_usuarios($pdo,$lista=1,$limite=10){
    $offset = ($lista -1)*$limite;
    $stmt = $pdo->prepare ("SELECT id, nombre, email FROM usuarios LIMIT :offset, :limite");
    $stmt->bindValue(':$offset',$offset,PDO::PARAM_INT);
    $stmt->bindValue(':$limite',$limite,PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function buscar_usuario($pdo,$criterio,$valor){
    $sql = "SELECT id, nombre, email FROM usuarios WHERE $criterio LIKE :valor";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':valor'=>'%'.sanitizar($valor).'%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function actualizar_usuario($pdo, $id, $datos) {
    $sql = "UPDATE usuarios SET nombre = :nombre, email = :email, contrasena = :contrasena WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre' => limpiar($datos['nombre']),
        ':email' => filter_var($datos['email'], FILTER_SANITIZE_EMAIL),
        ':contrasena' => password_hash($datos['contrasena'], PASSWORD_DEFAULT),
        ':id' => (int)$id
    ]);}
function eliminar_usuario($pdo, $id) {
    $sql = "DELETE FROM usuarios WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => (int)$id]);
}

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
        <input type="contrasena" name="contrasena" placeholder="contraseña" required>
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
            registro_usuario($pdo, $_POST['nombre'],$_POST['email'],$_POST['contrasena']);
            echo "usuario añadido correctamente.";
            break;

        case 'listar':
            $pagina = isset($_GET['nombre']) ? (int)$_GET['email'] : 1;
            $user = listar_usuarios($pdo, $pagina, 10);
            foreach ($user as $usuario) {
                echo "<p>{$usuario['nombre']} - {$usuario['email']} </p>";
            }
            break;

        case 'buscar':
            $criterio = $_GET['criterio'] ?? 'nombre';
            $valor = $_GET['valor'] ?? '';
            $resultados = buscar_usuario($pdo, $criterio, $valor);
            foreach ($resultados as $usuario) {
                echo "<p> {$usuario['id']}<{$usuario['nombre']} - {$usuario['email']}</p>";
            }
            break;

        case 'actualizar':
            $id = (int)$_POST['id'];
            $datos = [
                'nombre' => $_POST['nombre'],
                'email' => $_POST['email'],
                'contrasena' => $_POST['contrasena'],
            ];
            actualizar_usuario($pdo, $id, $datos);
            echo " usuario actualizado.";
            break;

        case 'eliminar':
            $id = (int)$_GET['id'];
            eliminar_usuario($pdo, $id);
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