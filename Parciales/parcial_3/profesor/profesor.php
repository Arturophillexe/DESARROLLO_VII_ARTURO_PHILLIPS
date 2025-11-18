<?php
require_once "../array_user.php";
session_start();
echo "aqui esta la session de ".$_SESSION['usuario']." con rol de ".$_SESSION['rol']."<br>";
foreach ($registro as $usuario=>$notas)



?>
<a href="../cierresession.php">cerrar session</a>