<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Tienda Digital</title>
  <style>
    body {
      margin: 0;
     /*overflow: hidden; Evita scroll al principio */
      overflow-y: scroll; /* Siempre muestra el scroll */
      font-family: Bernard MT Condensed, sans-serif;
      font-size: 32px;
          background-image: url('https://images.unsplash.com/photo-1710162734135-8dc148f53abe?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8Zm9uZG8lMjBzaW1wbGV8ZW58MHx8MHx8fDA%3D');
          background-size: cover;
          background-repeat: no-repeat;
          background-attachment: fixed;
    }

    .modal {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background-color: rgba(0, 0, 0, 0.6);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .modal-content {
      background: white;
      padding: 30px;
      border-radius: 10px;
      text-align: center;
      max-width: 500px;
      width: 90%;
    }

    .contenedor-comentarios {
      display: flex;
  justify-content: space-between;
  gap: 20px;
  padding: 20px;
  flex-wrap: nowrap; /* evita que se bajen */
}
.comentario,
.comentarioOLD {
  background: white;
  max-height: 400px; /* Altura máxima visible */
  overflow-y: auto;   /* Scroll vertical si se pasa */
  padding: 30px;
  border-radius: 10px;
  text-align: left;
  flex: 1; /* que ambos crezcan igual */
  max-width: 48%;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

    .hidden {
      display: none;
    }

    .scroll-content {
      padding: 20px;
    }

    .image-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 50px;
      justify-content: center;
    }

    .image-grid img {
      width: 30%; /* Ajusta para que quepan 3 por fila con espacio */
      height: 350px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .contenedor {
      background-color: #ffffff; 
      width:1900px;
      margin: 80px auto;/* Centrado vertical y horizontal */
      padding: 10px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.2);
      text-align: center;
    }
  </style>
</head>
<body>


<div id="loginModal" class="modal">
  <div class="modal-content">
    
   <h2>Registro de Usuario</h2>
    <form id="datosForm">
    <input type="text" placeholder="Usuario" id="usuario"><br><br>
    <input type="password" placeholder="Contraseña" id="clave"><br><br>
    <input type="edad" placeholder="edad" id="edad"><br><br>
    <input type="Tarjeta" placeholder="Tarjeta" id="tarjeta"><br><br>
    <button type="submit">Ingresar</button>
    </form>
  
  </div>
</div>
  

<div class="scroll-content">
<div class="contenedor">
    <h1>Bienvenidos A Nuestra Tienda</h1>
    <p>Categorías:</p>
  </div>

  <div class="image-grid">
  <img src="https://gitlab.com/imagenes8925815/IA/-/raw/main/Electrodomesticos.jpg" alt="Descripción de la imagen">
    <img src="https://gitlab.com/imagenes8925815/IA/-/raw/main/Computadoras.jpg" alt="Imagen 2">
    <img src="https://gitlab.com/imagenes8925815/IA/-/raw/main/Bocinas.jpg" alt="Imagen 3">
    <img src="https://gitlab.com/imagenes8925815/IA/-/raw/main/Tablets.jpg" alt="Imagen 4">
    
    <img src="https://gitlab.com/imagenes8925815/IA/-/raw/main/Celulares.jpg" alt="Imagen 5">
    <img src="https://gitlab.com/imagenes8925815/IA/-/raw/main/Perifericos.png" alt="Imagen 6">
  </div>
</div>


<script>

  document.getElementById("datosForm").addEventListener("submit", function(e) {
    e.preventDefault(); // Evita el envío normal del formulario

    const usuario = document.getElementById("usuario").value;
    const clave = document.getElementById("clave").value;
    const edad = document.getElementById("edad").value;
    const tarjeta = document.getElementById("tarjeta").value;

    if (usuario && clave&&edad&&tarjeta){

      document.getElementById("loginModal")?.classList.add("hidden");
      document.body.style.overflow = "auto";

      // Construcción de datos para el backend
      const datos = `Nombre=${usuario}, Contraseña=${clave}, Edad=${edad}, Tarjeta=${tarjeta}\n`;

      // Envío con fetch
      fetch("Servidor.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "datos=" + encodeURIComponent(datos)
      })
      .then(() => alert("Gracias por enviar tus datos."))
      .catch(error => console.error("Error al enviar:", error));
    } else {
      alert("Por favor, completa todos los campos.");
    }
  });
</script>

  <div class="contenedor-comentarios">
<div class="comentario">
<h2>Deja tu comentario</h2>
  <form action="guardarComentarios.php" method="POST">
    <input type="text" name="usuario" placeholder="Tu nombre"><br><br>
    <textarea name="comentario" rows="5" cols="30"></textarea><br>
    <input type="submit" value="Enviar">
  </form>
</div>

<div class="comentarioOLD">
  <h3>Comentarios anteriores:</h3>
  <?php
   
    $archivo = file_get_contents("comentarios.txt");
    echo $archivo; 
  ?>
  </div>
  </div>
</body>
</html>




