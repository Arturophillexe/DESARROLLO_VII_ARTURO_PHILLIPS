# para el ejercicio del taller 8


## instrucccion de configuracion
- Servidor local (recomendado: Laragon, XAMPP o similar)
- PHP 8.1+
- MySQL 5.7+
- Navegador web

## descripcion de mi estructura
base de datos usadas en los config
favor de ejecutar estas sentencias:
```sql
create DATABASE biblioteca_db
use biblioteca_db;
CREATE TABLE libros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    isbn VARCHAR(20) UNIQUE NOT NULL,
    anio_publicacion INT NOT NULL,
    cantidad_disponible INT NOT NULL
);
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);
CREATE TABLE prestamos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    libro_id INT NOT NULL,
    fecha_prestamo DATETIME NOT NULL,
    fecha_devolucion DATETIME DEFAULT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (libro_id) REFERENCES libros(id)
);
```
## concideraciones extra
con ayuda de una ia, me asegure que las operaciones usan consultas preparadas para evitar inyecciones SQL.

Se implementa validación y sanitización de entradas en cada módulo, use los config y les di la funcion de sanitizar

Las operaciones críticas (como préstamos y devoluciones) usan transacciones para garantizar consistencia.

Se incluye paginación en listados para mejorar rendimiento.

Las contraseñas se almacenan con password_hash() y se verifican con password_verify()

## comparativas entre MySQLi y PDO
mysql cierra con close(), pdo no lo utiliza para cerrar
PDO puede usar un nombre mientras que Mysqli usa solo Posicionales (?)
la flexibilidad de pdo es mucho mayor que la de Mysqli
el manejo de POO es mejor en Mysqli



## reflexiona sobre las siguientes preguntas:

### ¿Qué diferencias notaste al implementar el sistema con MySQLi y PDO?
lo primero fueron sus llamadas propias, cosas que tengan que ver con la conexion nesecitan
my sql nesecita ser llamado en su totalidad mientras que PDO es como si fuera una clase o funcion heredada.
### ¿Cuál de los dos métodos te pareció más fácil de usar y por qué?
PDO parece como si usara una clase de php, aunque tecnicamente despues del config todo funciona igual,
talvez es por como solo usaba mysql la mayor parte de mi vida.
### ¿Cómo manejaste la seguridad en ambas implementaciones?
la sanitizacion la puse como funcion en el config, podria haber hecho un sanitizar.php pero por pocas lineas de codigo creo que no daria tanto problema, el resto de problemas dificiles (Transacciones)
me fijaba mas en los try/catch y throw que nada.
### ¿Qué aspectos del sistema podrían mejorarse o expandirse en el futuro
sesiones: implementar sesiones con php con roles de admin y usuarios, tambien con su proteccion hecha
manejo de errores centralizado: se puede hacer el uso de una clase o modulo para capturar registrar y mostrar errores.

respecto al funciones:
-reservas de libros
-reportes y estadisticas
-categorias y generos