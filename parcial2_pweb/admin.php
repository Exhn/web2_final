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
    <style>
        .asunto{
            color:red;
        }
    </style>
    <title>Document</title>
    <?php
        if (!isset($_SESSION['usuario'])||$_SESSION['rol']!=1) {
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
    <a href="?alta"><button>ALTA PRODUCTO</button></a><br>
    <a href="?mostrar"><button>MOSTRAR PRODUCTOS</button></a><br>
    <form>
        <input type="hidden" name="buscar">
        Codigo: <input type="number" name="codigo"><input type="submit" value="Buscar">
    </form>
    <br>
    <a href="?leer"><button>Ver comentario</button></a><br>
    <?php
      if (isset($_GET['alta'])) {
        ?>
        <form method=POST>
            <input type="hidden" name="altaProducto">
            Nombre: <input type="text" name="nombre" maxlenght="30" required><br>
            Descripcion: <input type="text" name="desc" axlenght="70" required><br>
            Precio: <input type="number" name="precio" min="0" step="0.01" required>
            <input type="submit" value="Cargar producto">
        </form>
        <?php
    }

    if (isset($_POST['altaProducto'])) {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['desc'];
        $precio = $_POST['precio'];

        $sql = "insert into productos (nombre, descripcion, precio) values ('$nombre', '$descripcion', $precio);";

        mysqli_query($conn, $sql);

        if (mysqli_affected_rows($conn)>0) {
            echo "El producto $nombre se cargo bien";
        }else{
            echo "No se pudo cargar el producto";
        }
        mysqli_close($conn);
    }
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
            <form method="POST">
        <?php
        while ($result=mysqli_fetch_row($resultSet)) {
        ?>
            <tr>
                <td><?= $result[0] ?></td>
                <td><?= $result[1] ?></td>
                <td><?= $result[2] ?></td>
                <td><?= $result[3] ?></td>
                <td><input type="radio" name="cod" value="<?=$result[0]?>"></td>
            </tr>
        <?php
        }
        ?>
            <tr>
                <th colspan="5">
                    <input type="submit" value="Modificar" name="modificarTodos" formaction="?">
                    <input type="submit" value="Eliminar" name="eliminarTodos" formaction="?">
                </th>
            </tr>
            </form>
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
        <form method="POST">
        <?php
        while ($result=mysqli_fetch_row($resultSet)) {
        ?>
            <tr>
                <td><?= $result[0] ?></td>
                <td><?= $result[1] ?></td>
                <td><?= $result[2] ?></td>
                <td><?= $result[3] ?></td>
                <td><input type="radio" name="cod" value="<?=$result[0]?>"></td>
            </tr>
        <?php
        }
        ?>
         <tr>
                <th colspan="5">
                    <input type="submit" value="Modificar" name="modificar" formaction="?">
                    <input type="submit" value="Eliminar" name="eliminar" formaction="?">
                </th>
            </tr>
            </form>
        </table>
    <?php
    }

    if (isset($_POST['modificarTodos'])) {
        $codigo=$_POST['cod'];
        
        $sqlRegistro = "select * from productos where idProducto=$codigo";
        $sqlResult = mysqli_query($conn, $sqlRegistro);
        if (mysqli_affected_rows($conn)>0) {
            $finalResult = mysqli_fetch_row($sqlResult);
            ?>
            <form method="POST">
                <input type="hidden" name="codigo" value="<?=$finalResult[0]?>">
                Codigo: <?=$finalResult[0]?><br>
                Nombre: <input type="text" maxlenght="30" name="nombre" value="<?=$finalResult[1]?>" required><br>
                Descripcion: <input type="text" maxlenght="70" name="desc" value="<?=$finalResult[2]?>" required><br>
                Precio: <input type="number" min="0" step="0.1" name="precio" value="<?=$finalResult[3]?>" required><br>
                <input type="submit" value="Guardar cambios" name="guardarCambiosTodos">
            </form>
            <?php
        }else{
            echo "Error en la base de datos";
        }
    }

    if (isset($_POST['guardarCambiosTodos'])) {
        $codigo=$_POST['codigo'];
        $nombre=$_POST['nombre'];
        $descripcion=$_POST['desc'];
        $precio=$_POST['precio'];

        $sql="update productos set nombre='$nombre', descripcion='$descripcion', precio=$precio where idProducto=$codigo;";
        mysqli_query($conn, $sql);
        echo "Se modifico el registro con codigo: $codigo";
    }

    if (isset($_POST['eliminarTodos'])) {
        $codigo=$_POST['cod'];
        $sql="delete from productos where idProducto=$codigo;";
        mysqli_query($conn, $sql);
        echo "Se elimino el registro con codigo: $codigo";
    }

    if (isset($_POST['modificar'])) {
        $codigo=$_POST['cod'];
        
        $sqlRegistro = "select * from productos where idProducto=$codigo";
        $sqlResult = mysqli_query($conn, $sqlRegistro);
        if (mysqli_affected_rows($conn)>0) {
            $finalResult = mysqli_fetch_row($sqlResult);
            ?>
            <form method="POST">
                <input type="hidden" name="codigo" value="<?=$finalResult[0]?>">
                Codigo: <?=$finalResult[0]?><br>
                Nombre: <input type="text" maxlenght="30" name="nombre" value="<?=$finalResult[1]?>" required><br>
                Descripcion: <input type="text" maxlenght="70" name="desc" value="<?=$finalResult[2]?>" required><br>
                Precio: <input type="number" min="0" step="0.1" name="precio" value="<?=$finalResult[3]?>" required><br>
                <input type="submit" value="Guardar cambios" name="guardarCambios">
            </form>
            <?php
        }else{
            echo "Error en la base de datos";
        }
    }

    if (isset($_POST['guardarCambios'])) {
        $codigo=$_POST['codigo'];
        $nombre=$_POST['nombre'];
        $descripcion=$_POST['desc'];
        $precio=$_POST['precio'];

        $sql="update productos set nombre='$nombre', descripcion='$descripcion', precio=$precio where idProducto=$codigo;";
        mysqli_query($conn, $sql);
        echo "Se modifico el registro con codigo: $codigo";
    }

    if (isset($_POST['eliminar'])) {
        $codigo=$_POST['cod'];
        $sql="delete from productos where idProducto=$codigo;";
        mysqli_query($conn, $sql);
        echo "Se elimino el registro con codigo: $codigo";
    }

    if (isset($_GET['leer'])) {
        if (file_exists("comments.txt")) {
            $file=fopen("comments.txt", "r");
            $fsize=filesize("comments.txt");
            echo fread($file, $fsize);
            fclose($file);
        }else{
            echo "No hay comentarios en este momento";
        }
        
    }
    ?>
</body>
</html>