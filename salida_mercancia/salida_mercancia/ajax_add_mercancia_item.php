<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
 

	/*verificamos si las variables se envian*/

	if( empty($_POST['id_item']) || empty($_POST['id_despacho'])  ){
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
	$sql = "SELECT COUNT(*) AS total FROM TEMP_MERCANCIAS WHERE id_item =".$_POST['id_item']." AND id_despacho = ".$_POST['id_despacho'];
	$sqli = mysql_query($sql) or die(mysql_error());
	$rowi = mysql_fetch_assoc($sqli);
	
	if((int)$rowi['total'] == 0):
	
		$sql = sprintf("INSERT INTO `TEMP_MERCANCIAS` (id, id_item, id_despacho, cantidadc, costo_unidadcompra, iva2, orden_compra2, cantidade, costoinv, costocomp, costo_unitario, cantidadentinv, cantidadentcomp, valor_adjudicado) 
						VALUES (null, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d);",
			fn_filtro($_POST['id_item']),
			fn_filtro($_POST['id_despacho']),
			fn_filtro($_POST['cantidadc']),
			fn_filtro($_POST['costo_unidadcompra']),
			fn_filtro($_POST['iva2']),
			fn_filtro($_POST['orden_compra2']),
			fn_filtro($_POST['cantidade']),
			fn_filtro($_POST['costoinv']),
			fn_filtro($_POST['costocomp']),
			fn_filtro($_POST['costo_unitario']),
			fn_filtro($_POST['cantidadentinv']),
			fn_filtro($_POST['cantidadentcomp']),
			fn_filtro($_POST['valor_adjudicado'])
		);	
		
		if(!mysql_query($sql)){
			echo "Error de sql:\n$sql"; 
			exit;
		};	
		
		
	else:
		/*modificar el registro*/
		$sql = sprintf("UPDATE TEMP_MERCANCIAS SET 
							cantidadc = %d, 
							costo_unidadcompra = %d, 
							iva2 = %d, 
							orden_compra2 = %d, 
							cantidade = %d,
							costoinv = %d,
							costocomp = %d,
							costo_unitario = %d,
							cantidadentinv = %d, 
							cantidadentcomp = %d,
							valor_adjudicado = %d						
						 WHERE id_item = %d AND id_despacho = %d;",
			fn_filtro($_POST['cantidadc']),
			fn_filtro($_POST['costo_unidadcompra']),
			fn_filtro($_POST['iva2']),			
			fn_filtro($_POST['orden_compra2']),
			fn_filtro($_POST['cantidade']),
			fn_filtro($_POST['costoinv']),
			fn_filtro($_POST['costocomp']),
			fn_filtro($_POST['costo_unitario']),
			fn_filtro($_POST['cantidadentinv']),
			fn_filtro($_POST['cantidadentcomp']),
			fn_filtro($_POST['valor_adjudicado']),
			
			fn_filtro((int)$_POST['id_item']),
			fn_filtro((int)$_POST['id_despacho'])
			
		);
		if(!mysql_query($sql)){
			echo "Error de sql:\n$sql"; 
			exit;
		};		
	endif;
			
	/*if(!mysql_query($sql))

		echo "Error al actualizar el ingreso de mercancia:\n$sql";*/

	exit;

?>