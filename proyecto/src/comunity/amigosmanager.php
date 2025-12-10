<?php 
namespace Src\Interacciones;

class Amistad {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function enviarSolicitud($emisor_id, $receptor_id) {
        $sql = "INSERT INTO amistades (usuario_id_1, usuario_id_2, estado) VALUES (?, ?, 'pendiente')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$emisor_id, $receptor_id]);
    }

    public function aceptarSolicitud($solicitud_id) {
        $sql = "UPDATE amistades SET estado = 'aceptada' WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$solicitud_id]);
    }

    
    public function obtenerIdsAmigos($usuario_id) {
        $sql = "SELECT usuario_id_1, usuario_id_2 FROM amistades WHERE (usuario_id_1 = ? OR usuario_id_2 = ?) AND estado = 'aceptada'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuario_id, $usuario_id]);
        
        $amigos = [];
        while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $amigos[] = ($row['usuario_id_1'] == $usuario_id) ? $row['usuario_id_2'] : $row['usuario_id_1'];
        }
        return $amigos;
    }
}
?>