<?php

require 'admin/config.php';
require 'functions.php';

//conectar con la base de datos
$conexion = conexion($bd_config);

//Mostrar error en caso de no conectar
if (!$conexion) {
	header('Location: error.php');
}

//Obtener los post
$posts = obtener_post($blog_config['post_por_pagina'], $conexion);

//Redirigir si no hay post.
if(!$posts){
	header('Location: error.php');
}

require 'views/index.view.php';

?>