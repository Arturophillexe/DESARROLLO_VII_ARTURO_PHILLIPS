<?php
session_start();

$_SESSION = array();

session_destroy();

echo "Has cerrado sesión.";
?>