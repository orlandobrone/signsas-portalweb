<?php
	if(empty($_GET['html'])):
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Disposition: attachment;filename=Inventario_ACPM_export_".date('d-m-Y').".xls");
		header("Content-Transfer-Encoding: binary ");
	endif;


	include "../../conexion.php";
	include "../extras/php/basico.php";

	$query = "SELECT *
			  FROM inventario_acpm			
			  WHERE estado = 0 ORDER BY id DESC";
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

	

?>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">
        	<td align="center"><strong>ID</strong></td>
            <td align="center"><strong>C&oacute;digo</strong></td>
            <td align="center"><strong>Regi&oacute;n</strong></td>
            <td align="center"><strong>Identificaci&oacute;n Beneficiario</strong></td>
            <td align="center"><strong>Responsable</strong></td>
            <td align="center"><strong>Descripci&oacute;n</strong></td>
            <td align="center"><strong>Cantidad Galones</strong></td>
            <td align="center"><strong>Salida Galones</strong></td>
            <td align="center"><strong>Costo Unitario</strong></td>
            <td align="center"><strong>Costo ACPM</strong></td>
            <td align="center"><strong>Saldo Costo</strong></td>
            <td align="center"><strong>Promedio ACPM</strong></td>
            <td align="center"><strong>Departamento</strong></td>
            <td align="center"><strong>ID Hito (Reintegro)</strong></td>
            <td align="center"><strong>ID Hito (Saliente)</strong></td>
            <td align="center"><strong>ID Anticipo</strong></td>
            <td align="center"><strong>ID Anticipo Reintegro</strong></td>
            <td align="center"><strong>Fecha Registro</strong></td>
            <td align="center"><strong>Tipo Registro</strong></td>
        </tr>

<?php	

    $letters = array('-');
	$fruit   = array('/');	
	
	$totalGalA = 0;
	$totalGalR = 0;
	$promedio = 0;
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):
	
		$sql2 = "SELECT id, 
				 (SELECT valor FROM prestaciones WHERE id = ".$row['id_prestaciones'].") AS codigo,
				 (SELECT region FROM regional WHERE id = ".$row['id_regional'].") AS region,
				 (SELECT name FROM ps_state WHERE id = ".$row['id_ps_state'].") AS departamento,
				 (SELECT id_reintegro_anticipo FROM reintegros_acpm WHERE id_aplicado_anticipo = ".$row['id_anticipo'].") AS id_reintegro_anticipo
				 FROM hitos WHERE id = ".$row['id_hito'];
		$per2 = mysql_query($sql2);
		$rs_per2 = mysql_fetch_assoc($per2);		
		
		$totalGalA += $row['cant_galones'];
		$promedio += ($row['cant_galones'] * $row['costo_unitario']);
		
		
		$costoAcpm = $row['costo_unitario']*$row['cant_galones'];
		
?>
        <tr>
            <td bgcolor="#CCCCCC"><?=$row['id']?></td>
            <td><?=$rs_per2['codigo']?></td>
            <td><?=$rs_per2['region']?></td>
            <td><?=$row['beneficiarios']?></td>
            <td><?=$row['responsables']?></td>
            <td>Reintegro de ACPM</td>
            <td><?=$row['cant_galones']?></td>
            <td><?=$row['salida_acpm']?></td>  
            <td><?=$row['costo_unitario']?></td>
            <td><?=$costoAcpm?></td>
            <td><?=$costoAcpm?></td>
            <td><?=($row['cant_galones'] > 0)?($row['costo_unitario']*$row['cant_galones'])/$row['cant_galones']:0?></td>
            <td><?=$rs_per2['departamento']?></td>
            
            <td><?=$row['id_hito']?></td>
            <td>-</td>
            
            <td><?=$row['id_anticipo']?></td>
            <td><?=$rs_per2['id_reintegro_anticipo']?></td>
            <td><?=$row['fecha_registro']?></td>
            <td>Adici&oacute;n</td>
        </tr>
        

<?		
		$sql3 = "SELECT ia.*, sia.fecha AS fecha_salida
				 FROM salida_inventario_acpm AS sia
				 LEFT JOIN items_anticipo AS ia ON ia.id = sia.id_items_anticipo
				 WHERE sia.estado = 0 AND sia.id_inventario_acpm = ".$row['id'];
		$per3 = mysql_query($sql3);
		
		
		while($rs_per3 = mysql_fetch_assoc($per3)):
		
			
			$sql4 = "SELECT *
					 FROM anticipo
					 WHERE publicado != 'draft' AND id = ".$rs_per3['id_anticipo'];
			$per4 = mysql_query($sql4);
			$rs_per4 = mysql_fetch_assoc($per4);
			
			
			if( mysql_num_rows($per4) > 0 ):		
			
				$sql5 = "SELECT id, 
						 (SELECT region FROM regional WHERE id = ".$rs_per4['id_regional'].") AS region,
						 (SELECT name FROM ps_state WHERE id = hitos.id_ps_state) AS departamento,
						 (SELECT id_reintegro_anticipo FROM reintegros_acpm WHERE id_aplicado_anticipo = ".$rs_per3['id_anticipo'].") AS id_reintegro_anticipo
						 FROM hitos WHERE id = ".$rs_per3['id_hitos'];
				$per5 = mysql_query($sql5);
				$rs_per5 = mysql_fetch_assoc($per5);
				
				$totalGalR += $rs_per3['cant_galones'];
?>
                <tr>
                    <td bgcolor="#EBF8A4"><?=$rs_per3['id']?></td>
                    <td><?=$rs_per2['codigo']?></td>                
                    
                    <td><?=$rs_per5['region']?></td>
                    <td><?=$rs_per4['cedula_consignar']?></td>
                    <td><?=$rs_per4['nombre_responsable']?></td>
                    <td>Salida ACPM</td>
                    <td>0</td>
                    <td>-<?=$rs_per3['cant_galones']?></td>  
                    <td><?=$rs_per3['valor_galon']?></td>
                    <td>-<?=$rs_per3['valor_galon']*$rs_per3['cant_galones']?></td>
                    <td><?=$costoAcpm - ($rs_per3['valor_galon']*$rs_per3['cant_galones'])?></td>
                    <td><?=($rs_per3['valor_galon']*$rs_per3['cant_galones'])/$rs_per3['cant_galones']?></td>
                    <td><?=$rs_per5['departamento']?></td>
                    
                    <td><?=$row['id_hito']?></td>
                    <td><?=$rs_per3['id_hitos']?></td>
                    <td><?=$rs_per3['id_anticipo']?></td>
                    <td><?=$rs_per5['id_reintegro_anticipo']?></td>
                    <td><?=$rs_per3['fecha_salida']?></td>
                    <td>Retiro</td>
                </tr>	
<?			endif;
		endwhile;
	endwhile;
?>
	<tr>
            <td colspan="5"></td>
            <td>Total Gal. Reintegrados</td>
            <td bgcolor="#CCCCCC"><?=$totalGalA?></td>
            <td></td>
    </tr>
    <tr>
    		<td colspan="5"></td>
            <td>Total Gal. Salientes</td>
            <td></td>
            <td bgcolor="#CCCCCC"><?=$totalGalR?></td>
    </tr>
    
    <tr>
    		<td colspan="5"></td>
            <td>Total Gal. Disponibles</td>
            <td bgcolor="#CCCCCC"><?=$totalGalA-$totalGalR?></td>         
            
    </tr>

	</table>

    

