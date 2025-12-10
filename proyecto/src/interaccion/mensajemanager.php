<?php
require_once '../../config.php';

class MensajeManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function enviarMensaje($emisor_id, $receptor_id, $texto) {
        if (empty($texto) || empty($receptor_id)) {
            throw new InvalidArgumentException("Mensaje y receptor son requeridos");
        }

        try {
            $sql = "INSERT INTO mensajes (emisor_id, receptor_id, mensaje, fecha_envio) 
                    VALUES (?, ?, ?, NOW())";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$emisor_id, $receptor_id, $texto]);
        } catch (PDOException $e) {
            error_log("Error al enviar mensaje: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerConversacion($usuario1, $usuario2) {
        try {
            $sql = "SELECT m.*, 
                           u1.nombre as emisor_nombre,
                           u2.nombre as receptor_nombre
                    FROM mensajes m
                    JOIN usuarios u1 ON m.emisor_id = u1.id
                    JOIN usuarios u2 ON m.receptor_id = u2.id
                    WHERE (m.emisor_id = ? AND m.receptor_id = ?) 
                       OR (m.emisor_id = ? AND m.receptor_id = ?) 
                    ORDER BY m.fecha_envio ASC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$usuario1, $usuario2, $usuario2, $usuario1]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener conversación: " . $e->getMessage());
            return [];
        }
    }

    public function marcarComoLeido($mensaje_id, $usuario_id) {
        $sql = "UPDATE mensajes 
                SET leido = 1 
                WHERE id = ? AND receptor_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$mensaje_id, $usuario_id]);
    }

    public function obtenerMensajesNoLeidos($usuario_id) {
        $sql = "SELECT COUNT(*) as total 
                FROM mensajes 
                WHERE receptor_id = ? AND leido = 0";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuario_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../registro/views/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensajeManager = new MensajeManager($db);
    
    $emisor_id = $_SESSION['usuario_id'];
    $receptor_id = filter_input(INPUT_POST, 'receptor_id', FILTER_VALIDATE_INT);
    $texto = trim($_POST['mensaje'] ?? '');

    if ($receptor_id && !empty($texto)) {
        if ($mensajeManager->enviarMensaje($emisor_id, $receptor_id, $texto)) {
            $_SESSION['success'] = "Mensaje enviado correctamente";
        } else {
            $_SESSION['error'] = "Error al enviar el mensaje";
        }
    } else {
        $_SESSION['error'] = "Datos inválidos";
    }

    header("Location: ../views/mensajes.php?chat_con=" . $receptor_id);
    exit;
}
?>
