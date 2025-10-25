<?php
require_once "config_pdo.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST['id'];
    $nuevoNombre = $_POST['nombre'];
    $nuevoEmail = $_POST['email']; 
}


$sql = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":nombre", $nuevoNombre, PDO::PARAM_STR);
$stmt->bindParam(":email", $nuevoEmail, PDO::PARAM_STR);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    echo "Usuario actualizado correctamente.";
} else {
    echo "Error al actualizar: " . $stmt->errorInfo()[2];
}
unset($stmt);
unset($pdo);
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div><label>id</label><input type="number" name="id" required></div>
    <div><label>Nombre</label><input type="text" name="nombre" required></div>
    <div><label>Email</label><input type="email" name="email" required></div>
    <input type="submit" value="Actualizar Usuario">
</form>