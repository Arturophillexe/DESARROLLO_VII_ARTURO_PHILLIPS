<?php
session_start();
require_once '../../config.php';
require_once '../controllers/perfilmanager.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../registro/views/login.php");
    exit;
}

$perfilManager = new PerfilManager($db);
$perfil = $perfilManager->obtenerPerfil($_SESSION['usuario_id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../estilo/perfilstyle.css">
    <title>Mi Perfil</title>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <div>
                <a href="feed.php">Feed</a>
                <a href="amigos.php">Amigos</a>
                <a href="mensajes.php">Mensajes</a>
                <a href="perfil.php" class="active">Perfil</a>
            </div>
            <a href="../../registro/controllers/logout.php">Cerrar Sesión</a>
        </nav>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                echo htmlspecialchars($_SESSION['success']); 
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?php 
                echo htmlspecialchars($_SESSION['error']); 
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <div class="profile-card">
            <div class="profile-header">
                <img src="../../uploads/perfiles/<?php echo htmlspecialchars($perfil['foto_perfil'] ?? 'default.jpg'); ?>" 
                     alt="Foto de perfil" 
                     class="profile-photo">
                <h1><?php echo htmlspecialchars($perfil['username']); ?></h1>
                <p>Miembro desde <?php echo date('d/m/Y', strtotime($perfil['fecha_registro'])); ?></p>
            </div>
            <div class="form-section">
                <h2>Cambiar Foto de Perfil</h2>
                <form action="perfilmanager.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="file-input-wrapper">
                            <label for="foto_perfil" class="file-input-label">Seleccionar Imagen</label>
                            <input type="file" name="foto_perfil" id="foto_perfil" accept="image/*" required>
                        </div>
                        <span id="file-name" style="margin-left: 15px; color: #666;"></span>
                    </div>
                    <button type="submit" name="cambiar_foto" class="btn">Actualizar Foto</button>
                </form>
            </div>


            <div class="form-section">
                <h2>Cambiar Nombre de Usuario</h2>
                <form action="perfilmanager.php" method="POST">
                    <div class="form-group">
                        <label>Username Actual</label>
                        <input type="text" value="<?php echo htmlspecialchars($perfil['username']); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="nuevo_username">Nuevo Username</label>
                        <input type="text" name="nuevo_username" id="nuevo_username" 
                               placeholder="Ingresa tu nuevo username" required>
                    </div>
                    <button type="submit" name="cambiar_username" class="btn">Actualizar Username</button>
                </form>
            </div>



            <div class="form-section">
                <h2>Cambiar Contraseña</h2>
                <form action="perfilmanager.php" method="POST">
                    <div class="form-group">
                        <label for="contraseña_actual">Contraseña Actual</label>
                        <input type="password" name="contraseña_actual" id="contraseña_actual" required>
                    </div>
                    <div class="form-group">
                        <label for="nueva_contraseña">Nueva Contraseña</label>
                        <input type="password" name="nueva_contraseña" id="nueva_contraseña" required>
                        <small style="color: #666;">Mínimo 8 caracteres, debe incluir mayúsculas, minúsculas y números</small>
                    </div>
                    <div class="form-group">
                        <label for="confirmar_contraseña">Confirmar Nueva Contraseña</label>
                        <input type="password" name="confirmar_contraseña" id="confirmar_contraseña" required>
                    </div>
                    <button type="submit" name="cambiar_contraseña" class="btn">Cambiar Contraseña</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Mostrar nombre del archivo seleccionado
        document.getElementById('foto_perfil').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'Ningún archivo seleccionado';
            document.getElementById('file-name').textContent = fileName;
        });
    </script>
</body>
</html>