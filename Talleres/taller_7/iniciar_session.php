<?php
session_start();
$_SESSION['usuario']='el gran baron';
$_SESSION['rol']='admin';

echo "sesion iniciada para ".$_SESSION['usuario'];
?>