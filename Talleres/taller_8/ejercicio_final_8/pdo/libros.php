<?php
require_once 'config.php';
function añadir_libro($pdo, $titulo, $autor, $isbn, $anio, $cantidad) {
    $sql = "INSERT INTO libros (titulo, autor, isbn, anio_publicacion, cantidad_disponible)
            VALUES (:titulo, :autor, :isbn, :anio, :cantidad)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':titulo' => sanitizar($titulo),
        ':autor' => sanitizar($autor),
        ':isbn' => sanitizar($isbn),
        ':anio' => (int)$anio,
        ':cantidad' => (int)$cantidad
    ]);
}
function listar_libro($pdo, $pagina = 1, $limite = 10) {
    $offset = ($pagina - 1) * $limite;
    $sql = "SELECT * FROM libros LIMIT :offset, :limite";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function buscar_libro($pdo, $criterio, $valor) {
    $sql = "SELECT * FROM libros WHERE $criterio LIKE :valor";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':valor' => '%' . sanitizar($valor) . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function actualizar_libro($pdo, $id, $datos) {
    $sql = "UPDATE libros SET titulo = :titulo, autor = :autor, isbn = :isbn,
            anio_publicacion = :anio, cantidad_disponible = :cantidad WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':titulo' => sanitizar($datos['titulo']),
        ':autor' => sanitizar($datos['autor']),
        ':isbn' => sanitizar($datos['isbn']),
        ':anio' => (int)$datos['anio_publicacion'],
        ':cantidad' => (int)$datos['cantidad_disponible'],
        ':id' => (int)$id
    ]);
}
function eliminar_libro($pdo, $id) {
    $sql = "DELETE FROM libros WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => (int)$id]);
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
            añadir_libro($pdo, $_POST['titulo'], $_POST['autor'], $_POST['isbn'], $_POST['anio'], $_POST['cantidad']);
            echo "Libro añadido correctamente.";
            break;

        case 'listar':
            $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $libros = listar_libro($pdo, $pagina, 10);
            foreach ($libros as $libro) {
                echo "<p>{$libro['titulo']} - {$libro['autor']} ({$libro['anio_publicacion']})</p>";
            }
            break;

        case 'buscar':
            $criterio = $_GET['criterio'] ?? 'titulo';
            $valor = $_GET['valor'] ?? '';
            $resultados = buscar_libro($pdo, $criterio, $valor);
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
            actualizar_libro($pdo, $id, $datos);
            echo " Libro actualizado.";
            break;

        case 'eliminar':
            $id = (int)$_GET['id'];
            eliminar_libro($pdo, $id);
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