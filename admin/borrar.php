<?php session_start();

require 'config.php';
require '../functions.php';

// Comprobar si hay sesion iniciada, sino, redirigir.
comprobarSession();

// Conectar con la base de datos
$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

$id = limpiarDatos($_GET['id']);

// Comprobar que existe un ID
if (!$id) {
	header('Location:' . RUTA . '/admin');
}

$statement = $conexion->prepare('DELETE FROM articulos WHERE id = :id');
$statement->execute(array('id' => $id));

header('Location: ' . RUTA . '/admin');

?>