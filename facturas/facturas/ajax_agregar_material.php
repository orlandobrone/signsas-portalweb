<?

	include "../../conexion.php";

	include "../../ingreso_mercancia/extras/php/basico.php";

	

	/*verificamos si las variables se envian*/

	if(empty($_POST['id_ingreso'])){

		echo "Usted no a llenado todos los campos"; 

		exit;

	}

	

	//$search  = array('.', '$', ',');
	$search  = array('$', ',');

	$replace = array('');

	

	$costo = str_replace($search, $replace, $_POST['costo']);



	//echo $sql = sprintf("INSERT INTO `ingreso_mercancia` SELECT '',id_ingreso,'%s','%s',%s,%s,'%s',now() FROM ingreso_mercancia WHERE id = %s;",
	
	$sql = sprintf("INSERT INTO `ingreso_mercancia` (id,id_ingreso,id_material,id_proyecto,id_hito,cantidad,costo,iva,orden_compra,fecha,parent) VALUES (null, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', now(), 0);",


		fn_filtro($_POST['id_ingreso']),
		fn_filtro($_POST['id_material']),
		fn_filtro($_POST['id_proyecto']),
		fn_filtro($_POST['id_hito']),
		fn_filtro($_POST['cantidad']),
		fn_filtro($costo),
		fn_filtro($_POST['iva']),
		fn_filtro($_POST['orden_compra'])

	);	


	if(!mysql_query($sql)){

		echo "Error al guardar el ingreso de mercancia: ".$sql;

	}

?>