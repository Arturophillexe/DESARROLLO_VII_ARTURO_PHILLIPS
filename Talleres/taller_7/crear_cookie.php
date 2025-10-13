<?php
// Crear una cookie que expira en 1 hora
setcookie("usuario", "Arturo", time() + 3600, "/");

echo "Cookie 'usuario' creada.";
?>