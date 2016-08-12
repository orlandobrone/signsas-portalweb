<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	/*verificamos si las variables se envian*/

	if(empty($_POST['nommat']) || empty($_POST['descri'])|| empty($_POST['cosuni'])){

		echo "Usted no a llenado todos los campos";

		exit;

	}

	

	/*modificar el registro*/

	$letters = array(',');
	$fruit   = array('');	

	$sql = sprintf("UPDATE inventario SET 

					nombre_material='%s', descripcion='%s', cantidad='%s', costo_unidad='%s', codigo='%s' , ubicacion='%s' 

					WHERE id=%d;",

		fn_filtro($_POST['nommat']),

		fn_filtro($_POST['descri']),

		fn_filtro($_POST['cantid']),

		fn_filtro( str_replace($letters, $fruit, $_POST['cosuni'] )),

		fn_filtro($_POST['codigo']),

		fn_filtro($_POST['ubicacion']),

		fn_filtro((int)$_POST['id'])

	);

	if(!mysql_query($sql))

		echo "Error al actualizar el material:\n$sql";

	exit;

?>