<?php
if(isset($_SESSION['usuario'])){
    echo "hola nene como estas ". htmlspecialchars($_SESSION['usuario']) ."!<br>";
    echo "este es tu rol bro ". htmlspecialchars($_SESSION['rol']);
} else{echo "no has iniciado sesion bro :(";}
?>