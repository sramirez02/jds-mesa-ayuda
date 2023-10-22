<?php

$perfil = $_SESSION['rango'];

if ($perfil == 1) {
    require_once('perfil_1.php');
} elseif ($_SESSION['rango'] == 4) {
    require_once('perfil_4.php');
}

?>