<?php
session_start();
if (isset($_POST['autorizar'])) {


    date_default_timezone_set('America/Bogota');
    $usuario_adm = $_SESSION['usuario'];
    $fecha_autorizado = date('Y-m-d H:i');
    $id_estado = '4';
    $observaciones = ($_REQUEST['observaciones']);
    $v_importe = ($_REQUEST['importe']);
    $id_solicitud = $_SESSION['id_soli_r'];



    require_once('conexiondb.php');

    $sql = $conn->prepare("SELECT nombre FROM estado WHERE id = $id_estado");

    $sql->execute();

    $row = $sql->fetch(PDO::FETCH_OBJ);

    $nombre_estado = $row->nombre;


    $sql4 = "UPDATE solicitud SET id_estado = '$id_estado', observaciones = '$observaciones', importe = '$v_importe'  WHERE id = $id_solicitud";

    $conn->exec($sql4);

    $sql5 = "UPDATE observaciones SET fecha_autorizado = '$fecha_autorizado', usuario_adm = '$usuario_adm', estado_3 = '$nombre_estado' WHERE id_solicitud  = $id_solicitud";

    $conn->exec($sql5);

    $conn = null;
}

if (isset($_POST['negar'])) {


    date_default_timezone_set('America/Bogota');
    $usuario_adm = $_SESSION['usuario'];
    $fecha_negado = date('Y-m-d H:i');
    $id_estado = '5';
    $observaciones = ($_REQUEST['observaciones']);
    $v_importe = ($_REQUEST['importe']);
    $id_solicitud = $_SESSION['id_soli_r'];



    require_once('conexiondb.php');

    $sql = $conn->prepare("SELECT nombre FROM estado WHERE id = $id_estado");

    $sql->execute();

    $row = $sql->fetch(PDO::FETCH_OBJ);

    $nombre_estado = $row->nombre;


    $sql4 = "UPDATE solicitud SET id_estado = '$id_estado', observaciones = '$observaciones', importe = '$v_importe'  WHERE id = $id_solicitud";

    $conn->exec($sql4);

    $sql5 = "UPDATE observaciones SET fecha_autorizado = '$fecha_negado', usuario_adm = '$usuario_adm', estado_3 = '$nombre_estado' WHERE id_solicitud  = $id_solicitud";

    $conn->exec($sql5);

    $conn = null;
}
header('location:pendientesG.php');
?>