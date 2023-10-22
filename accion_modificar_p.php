<?php
if (isset($_POST['modificar'])) {

    $rango = ($_REQUEST['rango']);
    $usuario = ($_REQUEST['usuario']);

    require_once('conexiondb.php');

    $sql4 = "UPDATE empleado SET id_rango = $rango WHERE usuario  = '$usuario'";


    $conn->exec($sql4);

    $conn = null;
}
header('location:parametrizacion.php?e=ok');
?>