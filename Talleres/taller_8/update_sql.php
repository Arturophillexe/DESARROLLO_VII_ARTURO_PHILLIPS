<?php
require_once "config_mysqli.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id= mysqli_real_escape_string($conn, $_POST['id']);
    $nuevoNombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $nuevoEmail = mysqli_real_escape_string($conn, $_POST['email']);}

$sql = "UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "ssi", $nuevoNombre, $nuevoEmail, $id);
    if (mysqli_stmt_execute($stmt)) {
        echo "Usuario actualizado correctamente.";
    } else {
        echo "Error al actualizar: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div><label>id</label><input type="number" name="id" required></div>
    <div><label>Nombre</label><input type="text" name="nombre" required></div>
    <div><label>Email</label><input type="email" name="email" required></div>
    <input type="submit" value="Actualizar Usuario">
</form>