<?php
namespace Src\Registro;

class Autenticacion {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function registrarUsuario($nombre, $email, $password) {
        // Verificar si el email ya existe
        $check = $this->db->prepare("SELECT id FROM usuarios WHERE email = ?");
        $check->execute([$email]);
        
        if($check->rowCount() > 0) {
            return false; // El usuario ya existe
        }

        // Hashear password y guardar
        $passHash = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO usuarios (nombre, email, password, fecha_registro) VALUES (?, ?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([$nombre, $email, $passHash]);
    }
    
    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT id, password FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user['id']; // Retorna el ID para la sesión
        }
        return false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <label for="">nombre</label><input type="text" name="" id="">
        <label for="">usuario</label><input type="text" name="" id="">
        <label for="">fechanaci</label><input type="text" name="" id="">
        <label for="">contraseña</label><input type="text" name="" id="">
        <label for="">repetir contraseña</label><input type="text" name="" id="">
        <button type="submit"></button>
    </form>
</body>
</html>