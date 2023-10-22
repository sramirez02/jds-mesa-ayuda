<?php
session_start();

if (empty($_POST['usuario']) or empty($_POST['contrasena'])) {
    header("location: log_in.php");
} else {

    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "solicitudausencias";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $conn->prepare("SELECT empleado.id, empleado.nombre AS nombre_empleado, cargo.nombre AS nombre_cargo, area.nombre AS nombre_area, empleado.id_rango FROM (empleado 
            INNER JOIN cargo ON empleado.id_cargo = cargo.id
            INNER JOIN area ON cargo.id_area = area.id)
            WHERE usuario = '$usuario' AND contrasena = '$contrasena' ");
        $stmt->execute();




        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            $_SESSION['id'] = $row->id;
            $_SESSION['nombre'] = $row->nombre_empleado;
            $_SESSION['cargo'] = $row->nombre_cargo;
            $_SESSION['area'] = $row->nombre_area;
            $_SESSION['usuario'] = $usuario;
            $_SESSION['rango'] = $row->id_rango;

            header('location: inicio.php');
        } else {
            header('location: log_in.php');
        }
    } catch (PDOException $e) {
        echo "Conexion fallida: " . $e->getMessage();
    }

}


?>