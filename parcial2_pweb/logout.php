<?php
session_start();
echo "I bid you farewell ".$_SESSION['usuario'];
session_unset();
session_destroy();
echo "<br>Se cerro la sesion";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Document</title>
</head>
<body>
    <br>
    <a href="index.php"><button>Iniciar sesion</button></a>
</body>
</html>