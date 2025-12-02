<?php
require 'database.php';
$accion = $_GET['accion'] ?? 'lista';
switch ($accion){
    case 'crear':
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $precio= $_POST['precio'];
        $cantidad = $_POST['cantidad'];
            $stmt = $conn->prepare("INSERT INTO productos (nombre, categoria, precio, cantidad) VALUES (?, ?, ?, ?)");
    if(!$stmt)throw new Exception("vaya, fallo en preparacion: ".$conn->error);
    
    $newnombre = sanitizar($nombre);
    $newcategoria = sanitizar($categoria);
    $newprecio = (float)$precio;
    $newcantidad = (int)$cantidad;
    $stmt->bind_param("sssii", $newnombre, $newcategoria, $newprecio, $newcantidad);
    if (!$stmt->execute()) throw new Exception("error insertando el nuevo producto");
    $stmt->close();
    header('location: crear.php');
    break;

    case 'editar':
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $precio= $_POST['precio'];
        $cantidad = $_POST['cantidad'];
    $stmt = $conn->prepare("UPDATE productos SET nombre=?, categoria=?, precio=?, cantidad=? WHERE id=?");
    $stmt->bind_param("ssdii",
        sanitizar($nombre),
        sanitizar($categoria),
        $precio,
        $cantidad,
        $id
    );
    if (!$stmt->execute()) throw new Exception("Error al actualizar producto: " . $stmt->error);
    $stmt->close();
    header('location: editar.php');
        break;

    case 'eliminar':
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM productos WHERE id=?");
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) throw new Exception("Error al eliminar producto: " . $stmt->error);
    $stmt->close();
    header('location: index.php');
        break;

        default:
    function listar_productos($conn, $pagina = 1, $limite = 10) {
    $offset = ($pagina - 1) * $limite;
    $stmt = $conn->prepare("SELECT * FROM productos LIMIT ?, ?");
    $stmt->bind_param("ii", $offset, $limite);
    $stmt->execute();
    $result = $stmt->get_result();
    $productos = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $productos;
}
        break;
}





?>