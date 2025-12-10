<?php
require_once '../../config.php';

class PerfilManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function cambiarFoto($usuario_id, $imagen) {
        try {
            // Validar que sea una imagen
            $permitidos = ['image/jpeg', 'image/png', 'image/webp'];
            if (!in_array($imagen['type'], $permitidos)) {
                throw new Exception("Tipo de archivo no permitido");
            }

            // Validar tamaño (máximo 5MB)
            if ($imagen['size'] > 5 * 1024 * 1024) {
                throw new Exception("La imagen es demasiado grande");
            }

            // Crear directorio si no existe
            $uploadDir = '../../uploads/perfiles/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Generar nombre único
            $extension = pathinfo($imagen['name'], PATHINFO_EXTENSION);
            $nombreArchivo = uniqid('perfil_' . $usuario_id . '_') . '.' . $extension;
            $rutaDestino = $uploadDir . $nombreArchivo;

            // Obtener foto anterior para eliminarla
            $fotoAnterior = $this->obtenerFotoPerfil($usuario_id);

            // Mover archivo
            if (move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
                // Actualizar base de datos
                $sql = "UPDATE usuarios SET foto_perfil = ? WHERE id = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$nombreArchivo, $usuario_id]);

                // Eliminar foto anterior si existe y no es la por defecto
                if ($fotoAnterior && $fotoAnterior !== 'default.jpg') {
                    $rutaAnterior = $uploadDir . $fotoAnterior;
                    if (file_exists($rutaAnterior)) {
                        unlink($rutaAnterior);
                    }
                }

                return ['success' => true, 'foto' => $nombreArchivo];
            }

            throw new Exception("Error al subir la imagen");

        } catch (Exception $e) {
            error_log("Error al cambiar foto: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function cambiarUsername($usuario_id, $newUsername) {
        try {
            // Validar que el username no esté vacío
            $newUsername = trim($newUsername);
            if (empty($newUsername)) {
                throw new Exception("El nombre de usuario no puede estar vacío");
            }

            // Validar longitud
            if (strlen($newUsername) < 3 || strlen($newUsername) > 50) {
                throw new Exception("El nombre debe tener entre 3 y 50 caracteres");
            }

            // Validar caracteres permitidos (letras, números, guiones y guiones bajos)
            if (!preg_match('/^[a-zA-Z0-9_-]+$/', $newUsername)) {
                throw new Exception("Solo se permiten letras, números, guiones y guiones bajos");
            }

            // Verificar que el username no esté en uso
            $sql = "SELECT id FROM usuarios WHERE username = ? AND id != ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$newUsername, $usuario_id]);
            
            if ($stmt->fetch()) {
                throw new Exception("Este nombre de usuario ya está en uso");
            }

            // Actualizar username
            $sql = "UPDATE usuarios SET username = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$newUsername, $usuario_id]);

            return ['success' => true, 'username' => $newUsername];

        } catch (Exception $e) {
            error_log("Error al cambiar username: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function cambiarContraseña($usuario_id, $contraActual, $nuevaContra, $confirmarContra) {
        try {
            // Validar que las contraseñas coincidan
            if ($nuevaContra !== $confirmarContra) {
                throw new Exception("Las contraseñas no coinciden");
            }

            // Validar longitud mínima
            if (strlen($nuevaContra) < 8) {
                throw new Exception("La contraseña debe tener al menos 8 caracteres");
            }

            // Validar complejidad (opcional pero recomendado)
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/', $nuevaContra)) {
                throw new Exception("La contraseña debe contener al menos una mayúscula, una minúscula y un número");
            }

            // Verificar contraseña actual
            $sql = "SELECT password FROM usuarios WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$usuario_id]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$usuario || !password_verify($contraActual, $usuario['password'])) {
                throw new Exception("La contraseña actual es incorrecta");
            }

            // Hash de la nueva contraseña
            $hashNueva = password_hash($nuevaContra, PASSWORD_DEFAULT);

            // Actualizar contraseña
            $sql = "UPDATE usuarios SET password = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$hashNueva, $usuario_id]);

            return ['success' => true, 'message' => 'Contraseña actualizada correctamente'];

        } catch (Exception $e) {
            error_log("Error al cambiar contraseña: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    // Métodos auxiliares
    private function obtenerFotoPerfil($usuario_id) {
        $sql = "SELECT foto_perfil FROM usuarios WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuario_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['foto_perfil'] : null;
    }

    public function obtenerPerfil($usuario_id) {
        try {
            $sql = "SELECT id, username, email, foto_perfil, fecha_registro 
                    FROM usuarios WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$usuario_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener perfil: " . $e->getMessage());
            return null;
        }
    }

}
?>