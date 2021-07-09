<?php session_start();

//Cerrar la sesion actual
session_destroy();
$_SESSION = array();

header('Location: ../');
die();

?>