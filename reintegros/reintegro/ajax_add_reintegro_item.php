<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
 
	/*verificamos si las variables se envian*/
	if( empty($_POST['cantidad_reintegro']) ){
		echo "Debe ingresar la cantidad de reintegro";
		exit;
	}
	
	$sql4 = "SELECT COUNT(*) AS total FROM items_reintegro WHERE id_materiales = ".$_POST['id_materiales']." AND id_reintegro = ".$_POST['id_reintegro'];
    $pai4 = mysql_query($sql4); 
	$rs_pai4 = mysql_fetch_assoc($pai4);
	
	if($rs_pai4['total'] == 0 ):
	
		$sql = sprintf("INSERT INTO `items_reintegro` (id, id_reintegro, id_materiales, cantidade, valor_adjudicado, cantidad_reintegro, costo_reintegro, id_temp_mercancias, estado, id_inventario) VALUES (null, %d, %d, %d, %d, %d, %d, %d, 0, %d);",
			fn_filtro($_POST['id_reintegro']),
			fn_filtro($_POST['id_materiales']),
			fn_filtro($_POST['cantidade']),
			fn_filtro($_POST['valor_adjudicado']),
			fn_filtro($_POST['cantidad_reintegro']),
			fn_filtro($_POST['costo_reintegro']),
			fn_filtro($_POST['id_temp_mercancias']),
			fn_filtro($_POST['id_inventario'])	);	
		
		if(!mysql_query($sql)){
			echo "Error de sql:\n$sql"; 
			exit;
		};	
		
	else:
		$sql ="	UPDATE items_reintegro SET cantidad_reintegro = ".$_POST['cantidad_reintegro'].", costo_reintegro = ".$_POST['costo_reintegro']." WHERE id_materiales = ".$_POST['id_materiales']." AND id_reintegro = ".$_POST['id_reintegro'];
		
		if(!mysql_query($sql)){
			echo "Ocurrio un error\n$sql";
			exit;
		}
	endif;
		

		/*modificar el registro*/
		/*$sql = sprintf("UPDATE items_reintegro SET 
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