
<?php
require_once "config_pdo.php";
require_once "logger.php";

try {

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();

    $sql = "INSERT INTO usuarios (nombre, email) VALUES (:nombre, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre' => 'Nuevo Usuario (PDO)',
        ':email' => 'nuevo_pdo@example.com'
    ]);

    $usuario_id = $pdo->lastInsertId();

    $sql = "INSERT INTO publicaciones (usuario_id, titulo, contenido) VALUES (:usuario_id, :titulo, :contenido)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':titulo' => 'Publicación PDO',
        ':contenido' => 'Contenido de la nueva publicación PDO'
    ]);

    $pdo->commit();
    echo "Transacción (PDO) completada con éxito.";
} catch (Exception $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    log_error("PDO Error: " . $e->getMessage());
    echo "Error en la transacción (PDO): Se ha producido un problema. Por favor, intente más tarde.";
}
?>