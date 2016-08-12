<?
	include "../../conexion.php";
	include "../extras/php/basico.php";


	/*verificamos si las variables se envian*/

	if( empty($_POST['id_item']) || empty($_POST['id_mercancia']) || empty($_POST['campo']) || empty($_POST['valor']) ){
		echo "Usted no ha llenado todos los campos";
		exit;
	}
	
	// Creo el padre y hijo por primeraz de id_mercancia
	
	/*if(!isset($_REQUEST['id_parent'])):
	
		$sql = sprintf("INSERT INTO ingreso_mercancia SELECT NULL,MAX(id_ingreso)+1,0,0,0,0,0,0,0,now(),1 FROM ingreso_mercancia");
	
		if(!mysql_query($sql)){
			echo "Error al insertar El padre material:\n$sql"; 
			exit;
		};
		
		$id_ingreso = mysql_insert_id();		
		
	else:
		$id_ingreso = $_REQUEST['id_parent'];
	endif;*/

	$sqli = mysql_query("SELECT COUNT(*) AS total FROM TEMP_MERCANCIAS WHERE id_item =".$row['id_item']." AND id_despacho = ".$row['id_despacho'] ) or die(mysql_error());
	$rowi = mysql_fetch_assoc($sqli);

	if((int)$rowi['total'] > 0):
	
		$sql = sprintf("INSERT INTO `TEMP_MERCANCIAS` (id, id_item, id_despacho, cantidadc, costo2, iva2, orden_compra2, cantidade) 
						VALUES (null, '%s', '%s', 0,0,0,0,0,);",
			fn_filtro($_POST['id_item']),
			fn_filtro($_POST['id_despacho'])		
		);	
		
	else:
		/*modificar el registro*/
		$sql = sprintf("UPDATE TEMP_MERCANCIAS SET ".$_REQUEST['campo']."='%s' WHERE id_item = %d AND id_despacho = %d;",
			fn_filtro($_POST['valor']),
			fn_filtro((int)$_POST['id_item']),
			fn_filtro((int)$_POST['id_despacho'])
		);	
	endif;
		
	
	if(!mysql_query($sql)){
		echo "Error de sql:\n$sql"; 
		exit;
	};	


	

	/*if(!mysql_query($sql))

		echo "Error al actualizar el ingreso de mercancia:\n$sql";*/

	

	exit;

?>