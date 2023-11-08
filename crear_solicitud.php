<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('libraries/PHPMailer/src/PHPMailer.php');
require_once('libraries/PHPMailer/src/Exception.php');
require_once('libraries/PHPMailer/src/SMTP.php');

if (
    empty($_POST['motivo_solicitud'])
    or empty($_POST['observaciones'])
    or empty($_POST['lugar'])
) {
    header('location:nuevasolicitud.php');
} else {
    session_start();
    date_default_timezone_set('America/Bogota');
    $fecha_registro = date('Y-m-d H:i');
    $id_estado = '1';
    $lugar = $_POST['lugar'];
    $motivo_solicitud = ($_POST['motivo_solicitud']);
    $observaciones = ($_POST['observaciones']);
    $id_empleado = ($_SESSION['id']);

    // se importa el objeto de conexion a base de datos para realizar operaciones en ella
    require_once('conexiondb.php');

    // se inserta la nueva solicitud
    $sql = "INSERT INTO solicitud ( fecha_registro, id_empleado, id_estado, id_motivo, lugar, observaciones)
        VALUES ('$fecha_registro', '$id_empleado', '$id_estado', '$motivo_solicitud', '$lugar', '$observaciones')";
    // use exec() because no results are returned
    $conn->exec($sql);

    // se obtiene el nombre del motivo de la solicitud según el ID del formulario
    $get_solicitud_stmt = $conn->prepare("SELECT * FROM motivo_solicitud WHERE id = $motivo_solicitud");
    $get_solicitud_stmt->execute();
    $result = $get_solicitud_stmt->fetch(PDO::FETCH_OBJ);
    $nombre_solicitud = $result->nombre;

    $nombre_usuario = $_SESSION['nombre'];

    $destinatario = "sdanitzaramirez@gmail.com";
    $asunto = "Nueva solicitud de soporte técnico";
    $mensaje = "Colaborador sajoniano, \n\n
Se ha generado una nueva solicitud de soporte técnico con los siguientes datos:\n
Usuario: $nombre_usuario \n
Fecha de registro: $fecha_registro \n
Motivo de la solicitud: $nombre_solicitud \n
Lugar: $lugar \n
Observaciones: $observaciones \n\n
Su solicitud será atendida por orden de llegada y recibirá un correo con el fin de darle a conocer el proceso de la misma.\n\n
atentamente, area de soporte técnico";

    // Configurar el objeto PHPMailer
    $mail = new PHPMailer();
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    // TODO: configurar correo y contraseña desde el cual se enviarán los correos
    $mail->Username = 'sandy.r@jordandesajonia.edu.co';
    $mail->Password = 'Jordan2023';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom($mail->Username, 'Mesa de ayuda JDS');
    $mail->addAddress($destinatario);
    $mail->Subject = $asunto;
    $mail->Body = $mensaje;

    if ($mail->send()) {
        echo "Correo enviado correctamente";
    } else {
        echo "Error al enviar el correo: " . $mail->ErrorInfo;
    }
    $conn = null;
    header('location:solicitudes.php');
}
?>