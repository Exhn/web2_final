<?php
require "conn.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <title>Document</title>
    <?php
        if (!isset($_SESSION['usuario'])||$_SESSION['rol']!=2) {
            echo "Forbidden...";
            echo "<a href='index.php'><button>Iniciar sesion</button></a>";
            exit();
        }
    ?>
</head>
<body>
    <div class="sesion">
        Sesion iniciada como: <?=$_SESSION['usuario']?><br>
        <a href="logout.php"><button>Cerrar sesion</button></a>
    </div>
    <h1>Bienvenido <?=$_SESSION['usuario']?></h1>
    <h2>Supermercado Antonieta</h2>
    <a href="?mostrar"><button>MOSTRAR PRODUCTOS</button></a>
    <form>
        <input type="hidden" name="buscar">
        Codigo: <input type="number" name="codigo"><input type="submit" value="Buscar">
    </form>
    <br>
    <a href="?escribir"><button>Escribir comentario al administrador</button></a>

    <?php
    if (isset($_GET['mostrar'])) {
        $sql = "select * from productos;";

        $resultSet = mysqli_query($conn, $sql);
        ?>
        <table>
            <tr>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Precio</th>
            </tr>
        <?php
        while ($result=mysqli_fetch_row($resultSet)) {
        ?>
            <tr>
                <td><?= $result[0] ?></td>
                <td><?= $result[1] ?></td>
                <td><?= $result[2] ?></td>
                <td><?= $result[3] ?></td>
            </tr>
        <?php
        }
        ?>
        </table>
        <?php
    }

    if (isset($_GET['buscar'])) {
        $filtroCodigo = $_GET['codigo'];
        $sql = "select * from productos where idProducto = $filtroCodigo;";
        $resultSet = mysqli_query($conn, $sql);
        ?>
        <table>
            <tr>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Precio</th>
            </tr>
        <?php
        while ($result=mysqli_fetch_row($resultSet)) {
        ?>
            <tr>
                <td><?= $result[0] ?></td>
                <td><?= $result[1] ?></td>
                <td><?= $result[2] ?></td>
                <td><?= $result[3] ?></td>
            </tr>
        <?php
        }
        ?>
        </table>
    <?php
    }

    if (isset($_GET['escribir'])) {
        ?>
        <form method="POST" action="comentarios.php">
            Motivo:
            <select name="motivo">
                <option value="pregunta">Preguntas</option>
                <option value="sugerencia">Sugerencias</option>
            </select>
            <br>
            <textarea name="mensaje" required cols="30" rows="10" placeholder="Escriba aca su comentario..."></textarea>
            <br>
            <input type="submit" value="Enviar">
        </form>
        <?php
    }
    if (isset($_GET['ok'])) {
        echo "<br>Comentario enviado";
    }
    ?>
    
</body>
</html>