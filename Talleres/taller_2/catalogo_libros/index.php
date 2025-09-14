<?php
// Incluir funciones y templates
require './include/funciones.php';
require './include/header.php';

// Obtener lista de libros
$libros = obtenerLibros();

// Mostrar cada libro usando la función de detalle
foreach ($libros as $libro) {
    echo mostrarDetallesLibro($libro);
}

require './include/footer.php';
