<?php
function obtenerLibros() {
    return [
        [
            'titulo'            => 'El Quijote',
            'autor'             => 'Miguel de Cervantes',
            'anio_publicacion'  => 1605,
            'genero'            => 'Novela',
            'descripcion'       => 'La historia del ingenioso hidalgo Don Quijote de la Mancha.'
        ],
        [
            'titulo'            => 'Cien años de soledad',
            'autor'             => 'Gabriel García Márquez',
            'anio_publicacion'  => 1967,
            'genero'            => 'Realismo mágico',
            'descripcion'       => 'Crónica de la familia Buendía en el mítico pueblo de Macondo.'
        ],
        [
            'titulo'            => 'Orgullo y prejuicio',
            'autor'             => 'Jane Austen',
            'anio_publicacion'  => 1813,
            'genero'            => 'Romance',
            'descripcion'       => 'La compleja relación entre Elizabeth Bennet y el señor Darcy.'
        ],
        [
            'titulo'            => '1984',
            'autor'             => 'George Orwell',
            'anio_publicacion'  => 1949,
            'genero'            => 'Distopía',
            'descripcion'       => 'Un mundo sometido a vigilancia totalitaria y manipulación de la verdad.'
        ],
        [
            'titulo'            => 'El principito',
            'autor'             => 'Antoine de Saint-Exupéry',
            'anio_publicacion'  => 1943,
            'genero'            => 'Fábula filosófica',
            'descripcion'       => 'Un pequeño príncipe explora planetas y reflexiona sobre la naturaleza humana.'
        ],
    ];
}
function mostrarDetallesLibro(array $libro) {
    $html  = '<div class="libro">';
    $html .=     '<h2>' . htmlspecialchars($libro['titulo']) . '</h2>';
    $html .=     '<p><strong>Autor:</strong> ' . htmlspecialchars($libro['autor']) . '</p>';
    $html .=     '<p><strong>Año de publicación:</strong> ' . htmlspecialchars($libro['anio_publicacion']) . '</p>';
    $html .=     '<p><strong>Género:</strong> ' . htmlspecialchars($libro['genero']) . '</p>';
    $html .=     '<p>' . nl2br(htmlspecialchars($libro['descripcion'])) . '</p>';
    $html .= '</div>';

    return $html;
}
?>