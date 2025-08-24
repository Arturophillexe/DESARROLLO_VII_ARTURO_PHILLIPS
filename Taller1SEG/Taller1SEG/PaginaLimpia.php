<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Tienda Digital</title>
  <style>
    body {
      margin: 0;
      overflow: scroll; /* Evita scroll al principio */
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
      background-color: #ffffff; /* Fondo blanco */
      width:1900px;
      margin: 80px auto;/* Centrado vertical y horizontal */
      padding: 10px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.2);
      text-align: center;
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
  e.preventDefault();

  const usuario = document.getElementById("usuario").value;
  const clave = document.getElementById("clave").value;
  const edad = document.getElementById("edad").value;
  const tarjeta = document.getElementById("tarjeta").value;

  // Validación de los campos
  if (usuario && clave && edad && tarjeta) {
    // Validar que la edad sea un número
    if (isNaN(edad) || edad <= 0) {
      alert("Edad debe ser un número válido.");
      return;
    }

    // Validar que la tarjeta contenga solo números
    if (!/^\d+$/.test(tarjeta)) {
      alert("La tarjeta debe contener solo números.");
      return;
    }

    // Validación para prevenir scripts (XSS)
    const regexXSS = /<script.*?>.*?<\/script>/gi;
    if (regexXSS.test(usuario) || regexXSS.test(clave)) {
      alert("Los campos contienen contenido malicioso.");
      return;
    }

    const datos = {
      usuario,
      clave,
      edad,
      tarjeta
    };

    fetch("guardarDatosLimpios.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(datos)
    })
    .then(() => {
      alert("Datos guardados");
      document.getElementById("loginModal").classList.add("hidden");
      document.body.style.overflow = "auto";
    })
    .catch(err => console.error("Error:", err));
  } else {
    alert("Completa todos los campos");
  }
});

</script>

<div class="contenedor-comentarios">
<div class="comentario">
<h2>Deja tu comentario</h2>
<form id="datosComentarios">
    <input type="text" name="usuario" placeholder="Tu nombre"id="usuario"><br><br>
    <textarea name="comentario" rows="5" cols="30"id="comentario"></textarea><br>
    <input type="submit" value="Enviar">
  </form>
</div>

<div class="comentarioOLD">
  <h3>Comentarios anteriores:</h3>
  <?php
$archivo = file_get_contents("comentariosLimpios.txt");
echo $archivo; 
?>
<script>
document.getElementById("datosComentarios").addEventListener("submit", function(e) {
  e.preventDefault();

  const usuario = document.getElementById("usuario").value;
  const comentario = document.getElementById("comentario").value;


  // Validación de los campos
  if (usuario && comentario) {

    
    // Validación para prevenir scripts (XSS)
    const regexXSS = /<script.*?>.*?<\/script>/gi;
    if (regexXSS.test(usuario) || regexXSS.test(comentario)) {
      alert("Los campos contienen contenido malicioso.");
      return;
    }

    const datos = {
      usuario,
      comentario,
    
    };

    fetch("guardarComentariosLimpios.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(datos)
    })
    .then(() => {
      alert("Datos guardados");
     
    })
    .catch(err => console.error("Error:", err));
  } 
});

</script>
  </div>
  </div>
</body>
</html>

