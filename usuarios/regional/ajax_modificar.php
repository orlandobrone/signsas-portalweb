<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	

	/*verificamos si las variables se envian*/
	if(empty($_POST['region']) || empty($_POST['sigla']) || empty($_POST['id'])){
		echo "Usted no ha llenado todos los campos";
		exit;
	}

	

	/*modificar el registro*/

	$sql = sprintf("UPDATE regional SET region='%s', sigla='%s', estado=%d WHERE id=%d;",
		fn_filtro($_POST['region']),
		fn_filtro($_POST['sigla']),
		fn_filtro($_POST['cambio_estado']),
		fn_filtro((int)$_POST['id'])
	);



	if(!mysql_query($sql) or die(mysql_error()))
		echo "Error al actualizar el usuario:\n$sql";

	exit;

?>