<?
	include "../../conexion.php";
	include "../extras/php/basico.php";

/*verificamos si las variables se envian*/

	if(empty($_POST['id_apu']) 
	|| empty($_POST['descripcion']) ){
		echo "Usted no a llenado todos los campos";
		exit;
	}

	/*modificar el registro*/
	$sql = sprintf("UPDATE `apu` SET 

						descripcion='%s', 
						estado='publish'

				    WHERE id=%d;",

		fn_filtro($_POST['descripcion']),
		fn_filtro((int)$_POST['id_apu']) 

	);

	if(!mysql_query($sql)){

		echo "Error al actualizar el apu:\n$sql";

		exit;

	}
?>