<?php session_start();
require 'config.php';
require '../functions.php';

// Comprobamos hay session esta iniciada, sino, redirigir.
comprobarSession();

// Conectar con la base de datos
$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

// Comprobar si los datos han sido enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$titulo = limpiarDatos($_POST['titulo']);
	$extracto = limpiarDatos($_POST['extracto']);
	// Con la funcion nl2br transforma los saltos de linea en etiquetas <br>
	$texto = $_POST['texto'];
	$thumb = $_FILES['thumb']['tmp_name'];

	// Direccion final del archivo incluyendo el nombre
	# Importante concatenar al inicio '../' para bajar a la raiz.
	$archivo_subido = '../' . $blog_config['carpeta_imagenes'] . $_FILES['thumb']['name'];

	// Subir el archivo
	move_uploaded_file($thumb, $archivo_subido);

	$statement = $conexion->prepare(
		'INSERT INTO articulos (id, titulo, extracto, texto, thumb) 
		VALUES (null, :titulo, :extracto, :texto, :thumb)'
	);

	$statement->execute(array(
		':titulo' => $titulo,
		':extracto' => $extracto,
		':texto' => $texto,
		':thumb' => $_FILES['thumb']['name']
	));

	header('Location: ' . RUTA . '/admin');
}


require '../views/nuevo.view.php';

?>