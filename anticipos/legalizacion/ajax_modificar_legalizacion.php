<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	/*verificamos si las variables se envian*/

	/*if(empty($_POST['responsable']) || empty($_POST['fecha']) || empty($_POST['id_anticipo']) || empty($_POST['valor_fa'])

	|| empty($_POST['valor_legalizado'])

	|| empty($_POST['valor_pagar'])

	|| empty($_POST['lega_rein'])

	){

		echo "Usted no a llenado todos los campos";

		exit;

	}*/

	

	/*modificar el registro*/



	$sql = sprintf("UPDATE `legalizacion` SET 
					coordinador='%s', 
					id_tecnico='%s',
					id_beneficiario=%d
				WHERE id=%d;",
				
		fn_filtro($_POST['coordinador']),
		fn_filtro($_POST['id_tecnico']),	
		fn_filtro((int)$_POST['beneficiario']),	
		fn_filtro((int)$_POST['id_legalizacion'])		

	);
	
	if(!mysql_query($sql))

		echo "Error al actualizar el material:\n$sql";

	exit;

?>