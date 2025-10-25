<?php
require_once "config_mysqli.php";
require_once "logger.php"; 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {

    mysqli_begin_transaction($conn);


    $sql = "INSERT INTO usuarios (nombre, email) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    
    $nombre = "Nuevo Usuario (MySQLi)";
    $email = "nuevo_mysqli@example.com";
    mysqli_stmt_bind_param($stmt, "ss", $nombre, $email);
    mysqli_stmt_execute($stmt);
    
    $usuario_id = mysqli_insert_id($conn); 

    $sql = "INSERT INTO publicaciones (usuario_id, titulo, contenido) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    
    $titulo = "Publicación MySQLi";
    $contenido = "Contenido de la publicación...";
    mysqli_stmt_bind_param($stmt, "iss", $usuario_id, $titulo, $contenido);
    mysqli_stmt_execute($stmt);
    mysqli_commit($conn);
    echo "Transacción (MySQLi) completada con éxito.";

} catch (Exception $e) {

    mysqli_rollback($conn);
    
    log_error("MySQLi Error: " . $e->getMessage());
   
    echo "Error en la transacción (MySQLi): Se ha producido un problema. Por favor, intente más tarde.";


} finally {
    
    if (isset($conn)) {
        mysqli_close($conn);
    }
}
?>