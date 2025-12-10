<?php
require_once '../../estilo/header.php'; 
$misAmigos = $friendModel->obtenerIdsAmigos($_SESSION['usuario_id']);
$posts = $postModel->obtenerFeed($_SESSION['usuario_id'], $misAmigos);
?>

<div class="row justify-content-center">
    <div class="col-md-7">
        
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form action="publicar_action.php" method="POST" enctype="multipart/form-data">
                    <div class="d-flex mb-3">
                        <img src="avatar_default.png" class="avatar-small me-2">
                        <textarea name="contenido" class="form-control border-0" placeholder="¿Qué estás pensando?" rows="2"></textarea>
                    </div>
                    <div class="d-flex justify-content-between border-top pt-2">
                        <input type="file" name="imagen" class="form-control form-control-sm w-50">
                        <button type="submit" class="btn btn-primary btn-sm px-4">Publicar</button>
                    </div>
                </form>
            </div>
        </div>

        <?php foreach($posts as $post): ?>
        <div class="card mb-3 shadow-sm">
            <div class="card-header bg-white border-0 d-flex align-items-center">
                <img src="<?php echo $post['foto_perfil'] ?? 'default.jpg'; ?>" class="avatar-small me-2">
                <div>
                    <h6 class="mb-0">
                        <a href="../../usuario/views/perfil.php?id=<?php echo $post['autor_id']; ?>" class="text-decoration-none text-dark">
                            <?php echo htmlspecialchars($post['autor_nombre']); ?>
                        </a>
                    </h6>
                    <small class="text-muted"><?php echo date('d M H:i', strtotime($post['fecha'])); ?></small>
                </div>
            </div>
            
            <div class="card-body">
                <p class="card-text"><?php echo nl2br(htmlspecialchars($post['contenido'])); ?></p>
                <?php if($post['imagen']): ?>
                    <img src="../../../public/uploads/<?php echo $post['imagen']; ?>" class="img-fluid rounded">
                <?php endif; ?>
            </div>
            
            <div class="card-footer bg-white">
                <button class="btn btn-light btn-sm"><i class="bi bi-hand-thumbs-up"></i> Me gusta</button>
                <button class="btn btn-light btn-sm"><i class="bi bi-chat"></i> Comentar</button>
            </div>
        </div>
        <?php endforeach; ?>

    </div>
</div>

<?php require_once '../../estilo/footer.php'; ?>