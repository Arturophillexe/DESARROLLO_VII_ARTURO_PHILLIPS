<?php
function cargarProductos() {
    $json = file_get_contents('productos.json');
    return json_decode($json, true);
}
