<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['responsable']) || empty($_POST['fecha']) || empty($_POST['num_caja']) 
		|| empty($_POST['valor_fa'])
		|| empty($_POST['valor_legalizado'])
		|| empty($_POST['valor_pagar'])
		|| empty($_POST['lega_rein'])
		){
		echo "Usted no a llenado todos los campos";
		exit;
	}
	
	$sql = sprintf("INSERT INTO `legalizacion` VALUES ('', '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
		fn_filtro($_POST['responsable']),
		fn_filtro($_POST['fecha']),
		fn_filtro($_POST['num_caja']),
		fn_filtro($_POST['valor_fa']),
		fn_filtro($_POST['valor_legalizado']),
		fn_filtro($_POST['valor_pagar']),
		fn_filtro($_POST['lega_rein'])
	);

	if(!mysql_query($sql))
		echo "Error al insertar el nueva legalizacion:\n$sql"; 

	exit;
?>