<?php
require_once "config.php";
function registrarPrestamo($conn, $activosId, $libroId)
{
    $conn->begin_transaction();

    try {

        $stmt = $conn->prepare("SELECT cantidad_disponible FROM libros WHERE id=? FOR UPDATE");
        $stmt->bind_param("i", $libroId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) throw new Exception("Libro no encontrado.");
        $libro = $result->fetch_assoc();
        if ($libro['cantidad_disponible'] <= 0) throw new Exception("No hay copias disponibles.");
        $stmt->close();


        $stmt = $conn->prepare("INSERT INTO prestamos (usuario_id, libro_id, fecha_prestamo) VALUES (?, ?, NOW())");
        $stmt->bind_param("ii", $activosId, $libroId);
        if (!$stmt->execute()) throw new Exception("Error al registrar préstamo.");
        $stmt->close();


        $stmt = $conn->prepare("UPDATE libros SET cantidad_disponible = cantidad_disponible - 1 WHERE id=?");
        $stmt->bind_param("i", $libroId);
        if (!$stmt->execute()) throw new Exception("Error al Devolver inventario.");
        $stmt->close();

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        throw $e;
    }
}

function listarPrestamosActivos($conn, $lista = 1, $limite = 10)
{
    $offset = ($lista - 1) * $limite;
    $query = "
        SELECT p.id, u.nombre AS usuario, l.titulo AS libro, p.fecha_prestamo
        FROM prestamos p
        JOIN usuarios u ON p.usuario_id = u.id
        JOIN libros l ON p.libro_id = l.id
        WHERE p.fecha_devolucion IS NULL
        ORDER BY p.fecha_prestamo DESC
        LIMIT ?, ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $offset, $limite);
    $stmt->execute();
    $result = $stmt->get_result();
    $prestamos = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $prestamos;
}

// Registrar devolución
function registrarDevolucion($conn, $prestamoId)
{
    $conn->begin_transaction();

    try {
        // Obtener libro asociado
        $stmt = $conn->prepare("SELECT libro_id FROM prestamos WHERE id=? AND fecha_devolucion IS NULL FOR UPDATE");
        $stmt->bind_param("i", $prestamoId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) throw new Exception("Préstamo no encontrado o ya devuelto.");
        $libroId = $result->fetch_assoc()['libro_id'];
        $stmt->close();

        // Devolver préstamo
        $stmt = $conn->prepare("UPDATE prestamos SET fecha_devolucion = NOW() WHERE id=?");
        $stmt->bind_param("i", $prestamoId);
        if (!$stmt->execute()) throw new Exception("Error al registrar devolución.");
        $stmt->close();

        // Incrementar inventario
        $stmt = $conn->prepare("UPDATE libros SET cantidad_disponible = cantidad_disponible + 1 WHERE id=?");
        $stmt->bind_param("i", $libroId);
        if (!$stmt->execute()) throw new Exception("Error al Devolver inventario.");
        $stmt->close();

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        throw $e;
    }
}

// Historial de préstamos por usuario
function historialPrestamos($conn, $activosId)
{
    $stmt = $conn->prepare("
        SELECT l.titulo, p.fecha_prestamo, p.fecha_devolucion
        FROM prestamos p
        JOIN libros l ON p.libro_id = l.id
        WHERE p.usuario_id = ?
        ORDER BY p.fecha_prestamo DESC
    ");
    $stmt->bind_param("i", $activosId);
    $stmt->execute();
    $result = $stmt->get_result();
    $historial = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $historial;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>usuarios</title>
</head>
<header>
    <h1>bienvenido, que desea hacer?</h1>
</header>

<body>
    <h2>registrar Prestamo</h2>
    <form action="usuarios.php?accion=registrar" method="POST">
        <input type="number" name="userid" placeholder="id de la persona" required>
        <input type="number" name="bookid" placeholder="id del libro a registrar" required>
        <button type="submit">registrar</button>
    </form>

    <h2>listar prestamos</h2>
    <form action="usuarios.php" method="GET">
        <input type="text" name="valor" placeholder="Buscar...">
        <input type="hidden" name="accion" value="buscar">
        <button type="submit">ver</button>
    </form>

    <h2>Devolucion</h2>
    <form action="usuarios.php?accion=Devolver" method="POST">
        <input type="number" name="id" placeholder="ID del prestamo" required>
        <button type="submit">Devolver</button>
    </form>

    <h2>historial de prestamos</h2>
    <form action="usuarios.php" method="GET">
        <input type="number" name="id" placeholder="ID del usuario" required>
        <input type="hidden" name="accion" value="historial">
        <button type="submit">ver historial</button>
    </form>
    <?php
    $accion = isset($_GET['accion']) ? $_GET['accion'] : 'listar';

    try {
        switch ($accion) {
            case 'registrar':
                registrarPrestamo($conn, $_POST['userid'], $_POST['bookid']);
                echo "usuario añadido correctamente.";
                break;

            case 'listar':
                $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                $prestamos = listarPrestamosActivos($conn, $pagina, 10);
                foreach ($prestamos as $activos) {
                    echo "<p>{$activos['p.id']} - {$activos['usuario']} ({$activos['libros']})</p>";
                }
                break;

            case 'Devolver':
                $id = (int)$_POST['id'];
                $datos = [
                    'titulo' => $_POST['nombre'],
                    'autor' => $_POST['email'],
                    'isbn' => $_POST['contrasena'],
                ];
                registrarDevolucion($conn, $id);
                echo " usuario actualizado.";
                break;

            case 'historial':
                $id = (int)$_GET['id'];
                historialPrestamos($conn, $id);
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