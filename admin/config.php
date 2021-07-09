<?php

//Ruta raiz
define('RUTA', 'http://localhost/Evaluacion/blog_personal/');

//Base de datos
$bd_config = array(
	'basedatos' => 'blog_evaluacion',
	'usuario' => 'root',
	'pass' => ''
);


//Configuracion de contenido por pagina
$blog_config = array(
	'post_por_pagina'=> '2',
	'carpeta_imagenes' => 'imagenes/'
);

//informacion del login provicional
$blog_admin = array(
	'usuario' => 'Jhon',
	'password' => '123'
);

?>