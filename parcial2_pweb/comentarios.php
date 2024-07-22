<?php
session_start();
$motivo=$_POST['motivo'];
$comentario=$_POST['mensaje'];

$usuario=$_SESSION['usuario'];

$file=fopen("comments.txt", "a");

date_default_timezone_set("America/Argentina/Buenos_Aires");

$fecha=date("d-m-Y G:i");

$texto="<br>$fecha <span class='asunto'>$usuario</span> <br>Motivo: $motivo<br>$comentario\n";

if (fwrite($file, $texto)) {
    fclose($file);
    header("Location: emp.php?ok");
}else{
    echo "Error en el archivo del comentario";
}

?>