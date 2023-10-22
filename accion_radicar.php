<?php
session_start();
if (isset($_POST['radicar'])) {
    date_default_timezone_set('America/Bogota');
    $usuario_je_d = $_SESSION['usuario'];
    $fecha_radicado = date('Y-m-d H:i');
    $id_estado = '1';
    $observaciones = ($_REQUEST['observaciones']);
    $id_solicitud = $_SESSION['id_soli'];



    require_once('conexiondb.php');



    //  if (empty($_GET['id'])) {
    //  } else {
    //      $id = $_GET['id'];


    $sql = $conn->prepare("SELECT solicitud.fecha_registro, empleado.usuario, estado.nombre FROM ((solicitud 
        INNER JOIN empleado ON solicitud.id_empleado = empleado.id) 
        INNER JOIN estado ON solicitud.id_estado = estado.id) WHERE solicitud.id = '$id_solicitud'");
    // use exec() because no results are returned
    $sql->execute();

    $row = $sql->fetch(PDO::FETCH_OBJ);

    $f_registro = $row->fecha_registro;
    $us_empleado = $row->usuario;
    $est_1 = $row->nombre;


    $sql2 = "INSERT INTO observaciones (id_solicitud, fecha_registro, usuario_empleado, estado_1, fecha_radicado, usuario_jefe_d, estado_2) 
        VALUES ('$id_solicitud', '$f_registro', '$us_empleado', '$est_1', '$fecha_radicado', '$usuario_je_d', 'RADICADO')";

    $conn->exec($sql2);

    $sql3 = "UPDATE solicitud SET id_estado = '1', observaciones = '$observaciones' WHERE id = '$id_solicitud'";

    $conn->exec($sql3);
    //   }

    $conn = null;

}
if (isset($_POST['negar'])) {
    date_default_timezone_set('America/Bogota');
    $usuario_je_d = $_SESSION['usuario'];
    $fecha_negado = date('Y-m-d H:i');
    $id_estado = '5';
    $observaciones = ($_REQUEST['observaciones']);
    $id_solicitud = $_SESSION['id_soli'];



    require_once('conexiondb.php');



    $sql = $conn->prepare("SELECT solicitud.fecha_registro, empleado.usuario, estado.nombre FROM ((solicitud 
        INNER JOIN empleado ON solicitud.id_empleado = empleado.id) 
        INNER JOIN estado ON solicitud.id_estado = estado.id) WHERE solicitud.id = '$id_solicitud'");
    $sql->execute();

    $row = $sql->fetch(PDO::FETCH_OBJ);

    $f_registro = $row->fecha_registro;
    $us_empleado = $row->usuario;
    $est_1 = $row->nombre;

    $sql2 = "INSERT INTO observaciones (id_solicitud, fecha_registro, usuario_empleado, estado_1, fecha_radicado, usuario_jefe_d, estado_2) 
        VALUES ('$id_solicitud', '$f_registro', '$us_empleado', '$est_1', '$fecha_negado', '$usuario_je_d', 'NEGADO')";

    $conn->exec($sql2);

    $sql3 = "UPDATE solicitud SET id_estado = '5', observaciones = '$observaciones' WHERE id = '$id_solicitud'";

    $conn->exec($sql3);

    $conn = null;
}
if (isset($_POST['pendiente'])) {

    $id_estado = '3';
    $observaciones = ($_REQUEST['observaciones']);
    $id_solicitud = $_SESSION['id_soli'];


    require_once('conexiondb.php');


    $sql3 = "UPDATE solicitud SET id_estado = '3', observaciones = '$observaciones' WHERE id = '$id_solicitud'";

    $conn->exec($sql3);

    $conn = null;
}
header('location:gestionar.php');
?>