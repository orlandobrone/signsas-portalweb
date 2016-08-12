<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['responsable']) || empty($_POST['fecha']) || empty($_POST['id_anticipo']) || empty($_POST['valor_fa'])
	|| empty($_POST['valor_legalizado'])
	|| empty($_POST['valor_pagar'])
	|| empty($_POST['lega_rein'])
	){
		echo "Usted no a llenado todos los campos";
		exit;
	}
	
	/*modificar el registro*/

	$sql = sprintf("UPDATE `legalizacion` SET 
					responsable='%s', 
					fecha='%s', 
					id_anticipo='%s', 
					valor_fa='%s', 
					valor_legalizado='%s', 
					valor_pagar='%s', 
					lega_rein='%s', 
					fecha_edit= NOW() WHERE id=%d;",
					
		fn_filtro($_POST['responsable']),
		fn_filtro($_POST['fecha']),
		fn_filtro($_POST['num_caja']),
		fn_filtro($_POST['valor_fa']),
		fn_filtro($_POST['valor_legalizado']),
		fn_filtro($_POST['valor_pagar']),
		fn_filtro($_POST['lega_rein']),
		fn_filtro((int)$_POST['id'])
	);
	if(!mysql_query($sql))
		echo "Error al actualizar el material:\n$sql";
	exit;
?>