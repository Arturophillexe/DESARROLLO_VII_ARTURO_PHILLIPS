<?php
require_once 'config.php';


function registrarPrestamo($pdo, $usuarioId, $libroId) {
    try {
        $pdo->beginTransaction();

        
        $stmt = $pdo->prepare("SELECT cantidad_disponible FROM libros WHERE id = :libroId FOR UPDATE");
        $stmt->execute([':libroId' => $libroId]);
        $libro = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$libro) throw new Exception("Libro no encontrado.");
        if ($libro['cantidad_disponible'] <= 0) throw new Exception("No hay copias disponibles.");

        
        $stmt = $pdo->prepare("INSERT INTO prestamos (usuario_id, libro_id, fecha_prestamo) VALUES (:usuarioId, :libroId, NOW())");
        $stmt->execute([':usuarioId' => $usuarioId, ':libroId' => $libroId]);

        
        $stmt = $pdo->prepare("UPDATE libros SET cantidad_disponible = cantidad_disponible - 1 WHERE id = :libroId");
        $stmt->execute([':libroId' => $libroId]);

        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}


function listarPrestamosActivos($pdo, $pagina = 1, $limite = 10) {
    $offset = ($pagina - 1) * $limite;
    $sql = "
        SELECT p.id, u.nombre AS usuario, l.titulo AS libro, p.fecha_prestamo
        FROM prestamos p
        JOIN usuarios u ON p.usuario_id = u.id
        JOIN libros l ON p.libro_id = l.id
        WHERE p.fecha_devolucion IS NULL
        ORDER BY p.fecha_prestamo DESC
        LIMIT :offset, :limite";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function registrarDevolucion($pdo, $prestamoId) {
    try {
        $pdo->beginTransaction();

        
        $stmt = $pdo->prepare("SELECT libro_id FROM prestamos WHERE id = :id AND fecha_devolucion IS NULL FOR UPDATE");
        $stmt->execute([':id' => $prestamoId]);
        $prestamo = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$prestamo) throw new Exception("Préstamo no encontrado o ya devuelto.");
        $libroId = $prestamo['libro_id'];

        
        $stmt = $pdo->prepare("UPDATE prestamos SET fecha_devolucion = NOW() WHERE id = :id");
        $stmt->execute([':id' => $prestamoId]);

        
        $stmt = $pdo->prepare("UPDATE libros SET cantidad_disponible = cantidad_disponible + 1 WHERE id = :libroId");
        $stmt->execute([':libroId' => $libroId]);

        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}


function historialPrestamos($pdo, $usuarioId) {
    $stmt = $pdo->prepare("
        SELECT l.titulo, p.fecha_prestamo, p.fecha_devolucion
        FROM prestamos p
        JOIN libros l ON p.libro_id = l.id
        WHERE p.usuario_id = :usuarioId
        ORDER BY p.fecha_prestamo DESC
    ");
    $stmt->execute([':usuarioId' => $usuarioId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                registrarPrestamo($pdo, $_POST['userid'], $_POST['bookid']);
                echo "usuario añadido correctamente.";
                break;

            case 'listar':
                $pagina = isset($_GET['userid']) ? (int)$_GET['bookid'] : 1;
                $prestamos = listarPrestamosActivos($pdo, $pagina, 10);
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
                registrarDevolucion($pdo, $id);
                echo " usuario actualizado.";
                break;

            case 'historial':
                $id = (int)$_GET['id'];
                historialPrestamos($pdo, $id);
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