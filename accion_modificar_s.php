<?php
session_start();
if (isset($_POST['cancelar'])) {


    $usuario_adm = $_SESSION['usuario'];
    $id_estado = '6';
    $id_solicitud = $_SESSION['id_solicitud_actualizar'];



    require_once('conexiondb.php');

    $sql = $conn->prepare("SELECT nombre FROM estado WHERE id = $id_estado");

    $sql->execute();

    $row = $sql->fetch(PDO::FETCH_OBJ);

    $nombre_estado = $row->nombre;


    $sql4 = "UPDATE solicitud SET id_estado = '$id_estado' WHERE id = $id_solicitud";

    $conn->exec($sql4);
    $conn = null;
}

if (isset($_POST['modificar'])) {


    $usuario_adm = $_SESSION['usuario'];
    $id_estado = '2';
    $id_solicitud = $_SESSION['id_solicitud_actualizar'];
    $fecha_inicio = $_REQUEST['fecha_inicio'];
    $fecha_final = $_REQUEST['fecha_final'];
    $observaciones = $_REQUEST['observaciones'];



    require_once('conexiondb.php');

    $sql = $conn->prepare("SELECT nombre FROM estado WHERE id = $id_estado");

    $sql->execute();

    $row = $sql->fetch(PDO::FETCH_OBJ);

    $nombre_estado = $row->nombre;


    $sql4 = "UPDATE solicitud SET id_estado = '$id_estado', fecha_inicio = '$fecha_inicio', 
        fecha_final = '$fecha_final', observaciones = '$observaciones' WHERE id = $id_solicitud";

    $conn->exec($sql4);
    $conn = null;
}

header('location:solicitudes.php');
?>