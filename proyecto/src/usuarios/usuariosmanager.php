<?php 
namespace Src\Usuario;

class Usuario {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtener perfil completo (para mostrar en la vista de perfil)
    public function obtenerPerfil($usuario_id) {
        $sql = "SELECT id, nombre, email, foto_perfil, bio, fecha_registro FROM usuarios WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuario_id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function actualizarPerfil($id, $nombre, $bio, $foto = null) {
        // Lógica para actualizar datos. Si hay foto, se actualiza, si no, se mantiene.
        $sql = "UPDATE usuarios SET nombre = ?, bio = ? WHERE id = ?";
        $params = [$nombre, $bio, $id];
        
        if ($foto) {
            $sql = "UPDATE usuarios SET nombre = ?, bio = ?, foto_perfil = ? WHERE id = ?";
            $params = [$nombre, $bio, $foto, $id];
        }
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
}
?>