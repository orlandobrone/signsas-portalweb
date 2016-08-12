<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	/*verificamos si las variables se envian*/

	if(empty($_POST['placa']) || empty($_POST['marca'])){

		echo "Usted no a llenado todos los campos";

		exit;

	}

	

	/*modificar el registro*/

	$sql = sprintf("UPDATE vehiculos SET placa='%s', marca='%s' , soat='%s', tm='%s', aceite='%s', region='%s', planillas='%s', estado=%d WHERE id=%d;",

		fn_filtro($_POST['placa']),

		fn_filtro($_POST['marca']),	

		fn_filtro($_POST['soat']),

		fn_filtro($_POST['tm']),

		fn_filtro($_POST['aceite']),

		fn_filtro($_POST['region']),

		fn_filtro(serialize($_POST['plantillas'])), 
		
		fn_filtro((int)$_POST['estado']), 

		fn_filtro((int)$_POST['id'])

	);

	if(!mysql_query($sql))

		echo "Error al actualizar el material:\n$sql";

	exit;

?>