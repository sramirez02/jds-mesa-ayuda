    <?php

    if (
        empty($_POST['motivo_solicitud'])
        or empty($_POST['observaciones'])
        or empty($_POST['lugar'])
    ) {
        header('location:nuevasolicitud.php');
    } else {
        session_start();
        date_default_timezone_set('America/Bogota');
        $fecha_registro     =     date('Y-m-d H:i');
        $id_estado          =      '1';
        $lugar              =      $_POST['lugar'];
        $motivo_solicitud   =     ($_POST['motivo_solicitud']);
        $observaciones      =     ($_POST['observaciones']);
        $id_empleado        =     ($_SESSION['id']);


        require_once('conexiondb.php');


        $sql = "INSERT INTO solicitud ( fecha_registro, id_empleado, id_estado, id_motivo, lugar, observaciones)
        VALUES ('$fecha_registro', '$id_empleado', '$id_estado', '$motivo_solicitud', '$lugar', '$observaciones')";
        // use exec() because no results are returned
        $conn->exec($sql);



        $conn = null;

        header('location:solicitudes.php');
    }

    ?>