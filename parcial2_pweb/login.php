<?php
$usuario=$_POST['usuario'];
$password=$_POST['pass'];

require_once "conn.php";

$sql="select * from usuarios where usuario='$usuario';";
$resultset = mysqli_query($conn, $sql);
if (mysqli_affected_rows($conn)>0) {
    $row = mysqli_fetch_assoc($resultset);
    if ($password==$row['pass']) {
        session_start();
        $_SESSION['usuario']=$row['usuario'];
        $_SESSION['rol']=$row['rol'];
        switch ($_SESSION['rol']) {
            case 1:
                $file=fopen("accesos.txt", "a");
                date_default_timezone_set("America/Argentina/Buenos_Aires");
                $fecha=date("d-m-Y G:i");

                $texto="$fecha El usuario: $usuario ingreso al sistema con credenciales de Administrador\n";
                if (fwrite($file, $texto)) {
                    fclose($file);
                }else{
                    echo "Error al guardar info de login";
                }
                header("Location: admin.php");
                break;
            case 2:
                $file=fopen("accesos.txt", "a");
                date_default_timezone_set("America/Argentina/Buenos_Aires");
                $fecha=date("d-m-Y G:i");
                $texto="$fecha El usuario: $usuario ingreso al sistema con credenciales de Empleado\n";
                if (fwrite($file, $texto)) {
                    fclose($file);
                }else{
                    echo "Error al guardar info de login";
                }
                header("Location: emp.php");
                break;
            default:
                echo "Rol desconocido";
                exit();
                break;
        }
    }else {
        header("Location: index.php?noPass");
    }
}else {
    header("Location: index.php?noUsu=$usuario");
}
?>