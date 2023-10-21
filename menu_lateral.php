<?php 

$perfil = $_SESSION['rango'] ;

if ( $perfil == 1) {

require_once ('perfil_1.php');

} elseif ($_SESSION['rango'] == 2) {

    require_once ('perfil_2.php');

} elseif ($_SESSION['rango'] == 3) {

    require_once ('perfil_3.php');

} elseif ($_SESSION['rango'] == 4) {

    require_once ('perfil_4.php');

} ;


?>