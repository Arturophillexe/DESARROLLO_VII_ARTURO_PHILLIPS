<?php
namespace Src\Comunidad;

class Publicacion {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function crearPost($usuario_id, $contenido, $imagen = null) {
        $sql = "INSERT INTO publicaciones (usuario_id, contenido, imagen, fecha) VALUES (?, ?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$usuario_id, $contenido, $imagen]);
    }

    public function obtenerFeed($usuario_id, $ids_amigos) {
        
        $ids_amigos[] = $usuario_id; 
        
        
        $ids_placeholder = implode(',', array_fill(0, count($ids_amigos), '?'));

        
        $sql = "SELECT p.*, u.nombre as autor_nombre, u.foto_perfil as autor_foto 
                FROM publicaciones p
                JOIN usuarios u ON p.usuario_id = u.id
                WHERE p.usuario_id IN ($ids_placeholder)
                ORDER BY p.fecha DESC";
        
        $stmt = $this->db->prepare($sql);
        
        
        $stmt->execute($ids_amigos);
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>