<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	/*verificamos si las variables se envian*/

	if(empty($_POST['nommat']) || empty($_POST['descri']) || empty($_POST['cosuni']) || empty($_POST['codigo']) || empty($_POST['ubicacion'])){

		echo "Usted no a llenado todos los campos";

		exit;

	}



	$sql = sprintf("INSERT INTO `inventario` VALUES ('', '%s', '%s', '%s', '%s', '%s', '%s', now(),'%s',0);",

		fn_filtro($_POST['nommat']),

		fn_filtro($_POST['descri']),

		fn_filtro($_POST['cantid']),

		fn_filtro($_POST['cosuni']),
		
		fn_filtro($_POST['codigo']),

		fn_filtro($_POST['ubicacion']),
		
		fn_filtro($_POST['linea'])

	);



	if(!mysql_query($sql))

		echo "Error al insertar el nuevo material:\n$sql";



	exit;

?>