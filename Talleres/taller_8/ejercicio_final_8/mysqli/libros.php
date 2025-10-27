<?php
require_once 'config.php';


function add_libro($conn, $titulo,$autor,$isbn,$fecha,$cantidad)
{
    $stmt = $conn->prepare("INSERT INTO libros (titulo, autor, isbn, anio_publicacion, cantidad_disponible) VALUES (?, ?, ?, ?, ?)");
    if(!$stmt)throw new Exception("vaya, fallo en preparacion: ".$conn->error);
    
    $titulo = sanitizar($titulo);
    $autor = sanitizar($autor);
    $isbn = sanitizar($isbn);
    $fecha = (int)$fecha;
    $cantidad = (int)$cantidad;
    $stmt->bind_param("sssii", $titulo, $autor, $isbn, $fecha, $cantidad);
    if (!$stmt->execute()) throw new Exception("error insertando el nuevo libro");
    $stmt->close();
}
function listar_libro($conn, $pagina = 1, $limite = 10) {
    $offset = ($pagina - 1) * $limite;
    $stmt = $conn->prepare("SELECT * FROM libros LIMIT ?, ?");
    $stmt->bind_param("ii", $offset, $limite);
    $stmt->execute();
    $result = $stmt->get_result();
    $libros = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $libros;
}
function buscar_libro($conn, $criterio, $valor) {
    $valor = "%" . sanitizar($valor) . "%";
    $query = "SELECT * FROM libros WHERE $criterio LIKE ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $valor);
    $stmt->execute();
    $result = $stmt->get_result();
    $libros = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $libros;}

function actualizar_libro($conn, $id, $datos) {
    $stmt = $conn->prepare("UPDATE libros SET titulo=?, autor=?, isbn=?, anio_publicacion=?, cantidad_disponible=? WHERE id=?");
    $stmt->bind_param("sssiii",
        sanitizar($datos['titulo']),
        sanitizar($datos['autor']),
        sanitizar($datos['isbn']),
        (int)$datos['anio_publicacion'],
        (int)$datos['cantidad_disponible'],
        (int)$id
    );
    if (!$stmt->execute()) throw new Exception("Error al actualizar libro: " . $stmt->error);
    $stmt->close();
}
function eliminar_libro($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM libros WHERE id=?");
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) throw new Exception("Error al eliminar libro: " . $stmt->error);
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>libros</title>
</head>
<header><h1>bienvenido, que desea hacer?</h1></header>
<body>
    <h2>Añadir Libro</h2>
    <form action="libros.php?accion=añadir" method="POST">
        <input type="text" name="titulo" placeholder="Título" required>
        <input type="text" name="autor" placeholder="Autor" required>
        <input type="text" name="isbn" placeholder="ISBN" required>
        <input type="number" name="anio" placeholder="Año de publicación" required>
        <input type="number" name="cantidad" placeholder="Cantidad disponible" required>
        <button type="submit">Añadir</button>
    </form>

    <h2>Buscar Libro</h2>
    <form action="libros.php" method="GET">
        <select name="criterio">
            <option value="titulo">Título</option>
            <option value="autor">Autor</option>
            <option value="isbn">ISBN</option>
        </select>
        <input type="text" name="valor" placeholder="Buscar...">
        <input type="hidden" name="accion" value="buscar">
        <button type="submit">Buscar</button>
    </form>

    <h2>Actualizar Libro</h2>
    <form action="libros.php?accion=actualizar" method="POST">
        <input type="number" name="id" placeholder="ID del libro" required>
        <input type="text" name="titulo" placeholder="Nuevo título" required>
        <input type="text" name="autor" placeholder="Nuevo autor" required>
        <input type="text" name="isbn" placeholder="Nuevo ISBN" required>
        <input type="number" name="anio" placeholder="Nuevo año" required>
        <input type="number" name="cantidad" placeholder="Nueva cantidad" required>
        <button type="submit">Actualizar</button>
    </form>

    <h2>Eliminar Libro</h2>
    <form action="libros.php" method="GET">
        <input type="number" name="id" placeholder="ID del libro a eliminar" required>
        <input type="hidden" name="accion" value="eliminar">
        <button type="submit">Eliminar</button>
    </form>
    <?php
    $accion = isset($_GET['accion']) ? $_GET['accion'] : 'listar';

try {
    switch ($accion) {
        case 'añadir':
            add_libro($conn, $_POST['titulo'], $_POST['autor'], $_POST['isbn'], $_POST['anio'], $_POST['cantidad']);
            echo "Libro añadido correctamente.";
            break;

        case 'listar':
            $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $libros = listar_libro($conn, $pagina, 10);
            foreach ($libros as $libro) {
                echo "<p>{$libro['titulo']} - {$libro['autor']} ({$libro['anio_publicacion']})</p>";
            }
            break;

        case 'buscar':
            $criterio = $_GET['criterio'] ?? 'titulo';
            $valor = $_GET['valor'] ?? '';
            $resultados = buscar_libro($conn, $criterio, $valor);
            foreach ($resultados as $libro) {
                echo "<p> {$libro['titulo']} - {$libro['autor']}</p>";
            }
            break;

        case 'actualizar':
            $id = (int)$_POST['id'];
            $datos = [
                'titulo' => $_POST['titulo'],
                'autor' => $_POST['autor'],
                'isbn' => $_POST['isbn'],
                'anio_publicacion' => $_POST['anio'],
                'cantidad_disponible' => $_POST['cantidad']
            ];
            actualizar_libro($conn, $id, $datos);
            echo " Libro actualizado.";
            break;

        case 'eliminar':
            $id = (int)$_GET['id'];
            eliminar_libro($conn, $id);
            echo " Libro eliminado.";
            break;

        default:
            echo " Acción no reconocida.";
            break;
    }
} catch (Exception $e) {
    echo " Error: " . $e->getMessage();
}
?>
    <a href="index.php">volver</a>
</body>
</html>