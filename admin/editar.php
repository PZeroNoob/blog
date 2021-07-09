<?php session_start();
require 'config.php';
require '../functions.php';

//Conectar con base de datos
$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

// Comprobar si la hay session iniciada, sino, redirigir.
comprobarSession();

// Determinar si se estan enviado datos por el metodo POST o GET
# Si se envian por POST significa que el usuario los ha enviado desde el formulario
# por lo que tomamos los datos y los cambiamos en la base de datos.

# De otra forma significa que hay datos enviados por el metodo GET
# es decir, el ID que pasamos por la URL, si es asi entonces traemos los 
# datos de la base de datos a pantalla para que el usuario los pueda modificar.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Limpiar los datos para evitar que el usuario inyecte codigo.
	$titulo = limpiarDatos($_POST['titulo']);
	$extracto = limpiarDatos($_POST['extracto']);

	// Con la funcion nl2br transformamos los saltos de linea en etiquetas <br>
	// $texto = nl2br($_POST['texto']);
	$texto = $_POST['texto'];
	$id = limpiarDatos($_POST['id']);
	$thumb_guardada = $_POST['thumb-guardada'];
	$thumb = $_FILES['thumb'];

	# Comprobar que el nombre del thumb no este vacio, si lo esta
	# significa que el usuario no agrego una nueva thumb, entonces utilizar la thumb anterior.
	if (empty($thumb['name'])) {
		$thumb = $thumb_guardada;
	} else {
		// De otra forma cargamar la nueva thumb
		// Direccion final del archivo incluyendo el nombre
		# Importante  concatenar al inicio '../' para bajar a la raiz
		$archivo_subido = '../' . $blog_config['carpeta_imagenes'] . $_FILES['thumb']['name'];

		move_uploaded_file($_FILES['thumb']['tmp_name'], $archivo_subido);
		$thumb = $_FILES['thumb']['name'];

	}

	$statement = $conexion->prepare('UPDATE articulos SET titulo = :titulo, extracto = :extracto, texto = :texto, thumb = :thumb WHERE id = :id');
	$statement->execute(array(
		':titulo' => $titulo,
		':extracto' => $extracto,
		':texto' => $texto,
		':thumb' => $thumb,
		':id' => $id
	));

	header("Location: " . RUTA . '/admin');
} else {
	$id_articulo = id_articulo($_GET['id']);

	if (empty($id_articulo)) {
		header('Location: ' . RUTA . '/admin');
	}

	// Obtener el post por id
	$post = obtener_post_por_id($conexion, $id_articulo);

	// Si no hay post en el ID entonces redirigir.
	if (!$post) {
		header('Location: ' . RUTA . '/admin/index.php');
	}
	$post = $post[0];
}


require '../views/editar.view.php';

?>