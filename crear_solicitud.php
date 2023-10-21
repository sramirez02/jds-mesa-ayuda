    <?php

    if (
        empty($_POST['fecha_inicio']) or empty($_POST['fecha_final']) or empty($_POST['motivo_solicitud'])
        or empty($_POST['observaciones'])
    ) {
        header('location:nuevasolicitud.php');
    } else {
        session_start();
        date_default_timezone_set('America/Bogota');
        $fecha_registro     =     date('Y-m-d H:i');
        $id_estado          =      '2';
        $fecha_inicio       =     ($_POST['fecha_inicio']);
        $fecha_final        =     ($_POST['fecha_final']);
        $motivo_solicitud   =     ($_POST['motivo_solicitud']);
        $observaciones      =     ($_POST['observaciones']);
        $id_empleado        =     ($_SESSION['id']);
        $importe            =        '0';


        $segundosfecha_inicio     = strtotime($fecha_inicio);
        $segundosfecha_final      = strtotime($fecha_final);
        $segundostrascurridos = $segundosfecha_final - $segundosfecha_inicio;
        $minutostranscurridos = $segundostrascurridos / 60;
        $numero_horas         = $minutostranscurridos / 60;

        require_once('conexiondb.php');


        $sql = "INSERT INTO solicitud ( fecha_registro, id_empleado, id_estado, id_motivo, fecha_inicio, fecha_final, numero_horas, importe, observaciones)
        VALUES ('$fecha_registro', '$id_empleado', '$id_estado', '$motivo_solicitud', '$fecha_inicio', '$fecha_final', '$numero_horas', '$importe', '$observaciones')";
        // use exec() because no results are returned
        $conn->exec($sql);



        $conn = null;

        header('location:solicitudes.php');
    }

    ?>