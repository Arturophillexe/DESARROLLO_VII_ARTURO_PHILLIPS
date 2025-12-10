<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="">
</head>
<body>
    
    <form action="authenticador.php" method="post">
        <label for="usuario">ingrese su usuario</label>
        <input type="text" name="user" id="u" minlength="3"><br>
        <label for="contraseña">ingrese su contraseña</label>
        <input type="password" name="contra" id="c" minlength="5">
        <button type="submit" name="login">entrar</button>
    </form>
    <label for="registro">no tienes cuenta? </label>
    <a href="registrar.php">registrate aqui</a>
</body>
</html>
