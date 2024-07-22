<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="login.php">
        <h1>Ingreso al sistema</h1>
        Usuario: <input type="text" name="usuario" maxlenght="30" required placeholder="Ingrese su usuario..."><br>
        Password: <input type="password" name="pass" maxlenght="30" minlenght="4" required placeholder="Ingrese su contraseña..."><br>
        <input type="submit" value="Iniciar sesion">
    </form>
    <?php
    if (isset($_GET['noUsu'])) {
        echo "Usuario: ".$_GET['noUsu']." incorrecto!";
    }
    if (isset($_GET['noPass'])) {
        echo "You shall not pass...<br>Contraseña incorecta";
    }
    ?>
</body>
</html>