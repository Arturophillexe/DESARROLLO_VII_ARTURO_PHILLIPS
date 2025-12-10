<?php
session_start();
require_once '../../config.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../registro/views/login.php");
    exit;
}

// Obtener publicaciones del usuario y sus amigos
$sql = "SELECT p.*, u.username, u.foto_perfil,
        (SELECT COUNT(*) FROM likes WHERE publicacion_id = p.id) as total_likes,
        (SELECT COUNT(*) FROM likes WHERE publicacion_id = p.id AND usuario_id = ?) as me_gusta,
        (SELECT COUNT(*) FROM comentarios WHERE publicacion_id = p.id) as total_comentarios
        FROM publicaciones p
        INNER JOIN usuarios u ON p.usuario_id = u.id
        WHERE p.usuario_id = ? 
        OR p.usuario_id IN (
            SELECT CASE 
                WHEN usuario_id = ? THEN amigo_id 
                ELSE usuario_id 
            END
            FROM amistades 
            WHERE (usuario_id = ? OR amigo_id = ?) 
            AND estado = 'aceptada'
        )
        ORDER BY p.fecha_publicacion DESC
        LIMIT 50";
$stmt = $db->prepare($sql);
$uid = $_SESSION['usuario_id'];
$stmt->execute([$uid, $uid, $uid, $uid, $uid]);
$publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener datos del usuario actual
$sql = "SELECT username, foto_perfil FROM usuarios WHERE id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$uid]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed</title>
    <link rel="stylesheet" href="../../estilo/feedstyle.css">
</head>

<body>
    <div class="container">
        <nav class="navbar">
            <div>
                <a href="feed.php" class="active">Feed</a>
                <a href="amigos.php">Amigos</a>
                <a href="mensajes.php">Mensajes</a>
                <a href="perfil.php">Perfil</a>
            </div>
            <a href="../../registro/controllers/logout.php">Cerrar Sesión</a>
        </nav>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($_SESSION['success']);
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <div class="create-post">
            <div class="create-post-header">
                <img src="../../uploads/perfiles/<?php echo htmlspecialchars($usuario['foto_perfil'] ?? 'default.jpg'); ?>"
                    alt="Tu foto">
                <h3>¿Qué estás pensando, <?php echo htmlspecialchars($usuario['username']); ?>?</h3>
            </div>
            <form action="../controllers/publicacion_controller.php" method="POST" enctype="multipart/form-data">
                <textarea name="contenido" placeholder="Comparte algo con tus amigos..." required></textarea>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <input type="file" name="imagen" accept="image/*" style="font-size: 14px;">
                    <button type="submit" name="crear_publicacion" class="btn">Publicar</button>
                </div>
            </form>
        </div>


        <?php if (empty($publicaciones)): ?>
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                </svg>
                <h3>No hay publicaciones aún</h3>
                <p>Sé el primero en publicar algo o agrega amigos para ver su contenido</p>
            </div>
        <?php else: ?>
            <?php foreach ($publicaciones as $post): ?>
                <div class="post">
                    <div class="post-header">
                        <img src="../../uploads/perfiles/<?php echo htmlspecialchars($post['foto_perfil'] ?? 'default.jpg'); ?>"
                            alt="Foto">
                        <div class="post-header-info">
                            <h3><?php echo htmlspecialchars($post['username']); ?></h3>
                            <div class="time"><?php echo date('d/m/Y H:i', strtotime($post['fecha_publicacion'])); ?></div>
                        </div>
                        <?php if ($post['usuario_id'] == $uid): ?>
                            <form action="../controllers/publicacion_controller.php" method="POST" style="margin-left: auto;">
                                <input type="hidden" name="publicacion_id" value="<?php echo $post['id']; ?>">
                                <button type="submit" name="eliminar_publicacion" class="delete-btn"
                                    onclick="return confirm('¿Seguro que quieres eliminar esta publicación?')">
                                    Eliminar
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>

                    <div class="post-content">
                        <?php echo nl2br(htmlspecialchars($post['contenido'])); ?>
                    </div>

                    <?php if ($post['imagen']): ?>
                        <img src="../../uploads/publicaciones/<?php echo htmlspecialchars($post['imagen']); ?>"
                            class="post-image" alt="Imagen de publicación">
                    <?php endif; ?>

                    <div class="post-actions">
                        <form action="../controllers/like_controller.php" method="POST" style="display: inline;">
                            <input type="hidden" name="publicacion_id" value="<?php echo $post['id']; ?>">
                            <button type="submit" class="post-action <?php echo $post['me_gusta'] ? 'liked' : ''; ?>"
                                style="background: none; border: none; cursor: pointer;">
                                <svg viewBox="0 0 24 24" fill="<?php echo $post['me_gusta'] ? 'currentColor' : 'none'; ?>"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                                <span><?php echo $post['total_likes']; ?> Me gusta</span>
                            </button>
                        </form>

                        <div class="post-action" onclick="toggleComments(<?php echo $post['id']; ?>)">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                            <span><?php echo $post['total_comentarios']; ?> Comentarios</span>
                        </div>
                    </div>


                    <div class="comments-section" id="comments-<?php echo $post['id']; ?>" style="display: none;">
                        <?php
                        $sql = "SELECT c.*, u.username, u.foto_perfil 
                                FROM comentarios c
                                INNER JOIN usuarios u ON c.usuario_id = u.id
                                WHERE c.publicacion_id = ?
                                ORDER BY c.fecha_comentario ASC";
                        $stmt = $db->prepare($sql);
                        $stmt->execute([$post['id']]);
                        $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <?php foreach ($comentarios as $comentario): ?>
                            <div class="comment">
                                <img src="../../uploads/perfiles/<?php echo htmlspecialchars($comentario['foto_perfil'] ?? 'default.jpg'); ?>"
                                    alt="Foto">
                                <div class="comment-content">
                                    <div class="comment-author"><?php echo htmlspecialchars($comentario['username']); ?></div>
                                    <div class="comment-text"><?php echo htmlspecialchars($comentario['comentario']); ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <form action="../controllers/comentario_controller.php" method="POST" class="comment-form">
                            <img src="../../uploads/perfiles/<?php echo htmlspecialchars($usuario['foto_perfil'] ?? 'default.jpg'); ?>"
                                alt="Tu foto">
                            <input type="hidden" name="publicacion_id" value="<?php echo $post['id']; ?>">
                            <input type="text" name="comentario" placeholder="Escribe un comentario..." required>
                            <button type="submit" class="btn">Comentar</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script>
        function toggleComments(postId) {
            const commentsSection = document.getElementById('comments-' + postId);
            if (commentsSection.style.display === 'none') {
                commentsSection.style.display = 'block';
            } else {
                commentsSection.style.display = 'none';
            }
        }
    </script>
</body>

</html>