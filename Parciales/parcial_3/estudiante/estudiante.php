<?php
require_once "../array_user.php";
session_start();
echo "aqui esta la session de ".$_SESSION['usuario']." con rol de ".$_SESSION['rol']."<br>";
foreach ($registro as $usuario=>$notas)
{if($notas["nombre"]==$_SESSION['usuario'])
    $userNotas['notas']=$notas['notas'];
}
foreach ($userNotas as $notasu);
echo "notas <br>";
print ($notasu["matematicas"]."<br>");
print ($notasu["español"]."<br>");
print ($notasu["informatica"]."<br>");

?>
<br><a href="../cierresession.php">cerrar session</a>