<?php
session_start();
if (isset($_SESSION['id'])) {
    require_once('menu_superior.php');
    require_once('menu_lateral.php');
    require_once('vista_inicio.php');
    require_once('piedepagina.php');
} else {
    header('Location: log_in.php');
}

?>