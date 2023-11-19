<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('libraries/PHPMailer/src/PHPMailer.php');
require_once('libraries/PHPMailer/src/Exception.php');
require_once('libraries/PHPMailer/src/SMTP.php');


session_start();
if (isset($_POST['cancelar'])) {
    date_default_timezone_set('America/Bogota');
    $fecha_registro = date('Y-m-d H:i');
    $usuario_adm = $_SESSION['usuario'];
    $lugar = $_POST['lugar'];
    $motivo_solicitud = $_POST['motivo_solicitud'];
    $observaciones = $_POST['observaciones'];
    $id_empleado = ($_SESSION['id']);
    $id_estado = '6';
    $id_solicitud = $_SESSION['id_solicitud_actualizar'];


    require_once('conexiondb.php');

    $sql = $conn->prepare("SELECT nombre FROM estado WHERE id = $id_estado");
    $sql->execute(); 

    $row = $sql->fetch(PDO::FETCH_OBJ);

    $nombre_estado = $row->nombre;


    $sql4 = "UPDATE solicitud SET id_estado = '$id_estado' WHERE id = $id_solicitud";

    $conn->exec($sql4);

$get_solicitud_stmt2 = $conn->prepare("SELECT * FROM motivo_solicitud WHERE id = $motivo_solicitud");
$get_solicitud_stmt2->execute();
$result = $get_solicitud_stmt2->fetch(PDO::FETCH_OBJ);
$nombre_solicitud = $result->nombre;


    $nombre_usuario = $_SESSION['nombre'];

$destinatario = "sdanitzaramirez@gmail.com";
$destinatario2 = "danitzarico1234@gmail.com";
$asunto = "Solicitud cancelada de soporte técnico";
$mensaje = "Colaborador sajoniano, \n\n
Se ha generado la cancelación de la solicitud de soporte técnico con los siguientes datos:\n
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
$mail->addAddress($destinatario2);
$mail->Subject = $asunto;
$mail->Body = $mensaje;


if ($mail->send()) {
    echo "Correo enviado correctamente";
} else {
    echo "Error al enviar el correo: " . $mail->ErrorInfo;
}

header('location:solicitudes.php');
}
?>