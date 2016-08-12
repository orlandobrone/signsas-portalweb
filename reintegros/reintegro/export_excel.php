<?php

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=Reintegro_export_".date('d-m-Y').".xls");
	header("Content-Transfer-Encoding: binary ");
	

	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	
	if(!empty($_GET['fecini']) && !empty($_GET['fecfin'])){		
		$where = " AND (fecha_ingreso BETWEEN '".$_GET['fecini']."' AND '".$_GET['fecfin']."') ";
		echo 'Fecha desde:'.$_GET['fecini']."' hasta '".$_GET['fecfin'];
	}

	$query = "SELECT *
			  FROM reintegros			
			  WHERE estado != 0 ".$where." ORDER BY id DESC";

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	
	$obj = new TaskCurrent;

?>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">
        	<td align="center"><strong>ID</strong></td>
            <td align="center"><strong>ID Salida de Mercancia</strong></td>
            <td align="center"><strong>OT</strong></td> 
            <td align="center"><strong>ID Hito</strong></td>
			<td align="center"><strong>Nombre Hito</strong></td>          
            <td align="center"><strong>Total Reintegro</strong></td>
            <td align="center"><strong>Usuario</strong></td>
            <td align="center"><strong>Fecha Ingreso</strong></td>
            
            <td align="center"><strong>Item</strong></td>
            <td align="center"><strong>C&oacute;digo</strong></td>
            <td align="center"><strong>Nombre Material</strong></td>
            <td align="center"><strong>Cant. Total Adjudicado</strong></td>
            <td align="center"><strong>Valor Uni. Adjudicado</strong></td>
            
            <td align="center"><strong>Cant. Reintegro </strong></td>
            <td align="center"><strong>Costo Total Reintegro</strong></td>            
             
        </tr>
<?php	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):

		$sqlPry = "SELECT * FROM items_reintegro WHERE id_reintegro = ".$row['id'];
		$qrPry = mysql_query($sqlPry);
		
		while($rsPry = mysql_fetch_array($qrPry)):
		
			$sqlfgr2 = " SELECT nombre, id_regional, 
						(SELECT nombre FROM hitos WHERE id = ".$row['id_hito'].") AS nombre_hito,
						(SELECT usuario FROM usuario WHERE id = ".$row['id_usuario'].") AS nombre_user  
						 FROM proyectos WHERE  id = ".$row['id_proyecto'];
			$paifgr2 = mysql_query($sqlfgr2);
			$otfgr = mysql_fetch_assoc($paifgr2);			
			
			$estado = '';
			$editado = '';
			$aprobar = '';
			$eliminar = '';
			$btn_aprobar = '';
	  
			$sql2 = "SELECT nombre_material, codigo FROM inventario WHERE codigo = ".$rsPry['id_inventario'];
			$pai2 = mysql_query($sql2); 
			$rs_pai2 = mysql_fetch_assoc($pai2);
			
			$sql3 = "SELECT * FROM TEMP_MERCANCIAS WHERE id_item = ".$rsPry['id_materiales'];
			$pai3 = mysql_query($sql3); 
			$rs_pai3 = mysql_fetch_assoc($pai3);		
			
			$cantidade =($rs_pai3['cantidade'] != '')?$rs_pai3['cantidade']:0; // total de cantidad entregada
			$valor_adjudicado =($rs_pai3['valor_adjudicado'] != '')?$rs_pai3['valor_adjudicado']:0;
			//$total = $cantidade * $valor_adjudicado; 	
			
			$sql4 = "SELECT SUM(cantidad_reintegro) AS total_cant_reintegro 
					 FROM items_reintegro WHERE estado = 1 AND id_materiales = ".$rsPry['id_materiales']." AND id_temp_mercancias = ".$rsPry['id_temp_mercancias'];
			$pai4 = mysql_query($sql4); 
			$rs_pai4 = mysql_fetch_assoc($pai4);			
			
?>
            <tr>
                    <td bgcolor="#CCCCCC"><?=$row['id']?></td>
                    <td><?=$row['id_salida_mercancia']?></td>
                    <td><?=utf8_encode($otfgr['nombre'])?></td> 
                    <td><?=$row['id_hito']?></td>
                    <td><?=utf8_encode($otfgr['nombre_hito'])?></td>
                    <td><?=$row['total_reintegro']?></td>
                   	<td><?=$otfgr['nombre_user']?></td>
                    <td><?=$row['fecha_ingreso']?></td>
            
                    <td><?=$rsPry['id']?></td> 
                    <td><?=$rs_pai2['codigo']?></td>
                    <td><?=utf8_encode($rs_pai2['nombre_material'])?></td>
                    <td><?=$cantidade?></td>                    
                    <td><?=$obj->clearInt($valor_adjudicado)?></td>
                    
                    <td><?=$rsPry['cantidad_reintegro']?></td>
                    <td><?=$obj->clearInt($rsPry['costo_reintegro'])?></td>
             </tr>
<?		
		endwhile;
	endwhile;
?>
	</table>

    

