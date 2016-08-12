<?php

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=Orden_Servicio_export_".date('d-m-Y').".xls");
	header("Content-Transfer-Encoding: binary");


	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	
	if(!empty($_GET['fecini']) && !empty($_GET['fecfin'])){		
		$where = " AND (fecha_create BETWEEN '".$_GET['fecini']."' AND '".$_GET['fecfin']."') ";
		echo 'Fecha desde:'.$_GET['fecini']."' hasta '".$_GET['fecfin'];
	}

	$query = "SELECT * FROM `orden_servicio` WHERE `estado`='publish' ".$where." ORDER BY id DESC";
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	
	
?>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">

        	<td align="center"><strong>ID</strong></td>

            <td align="center"><strong>Fecha de Inicio</strong></td>
            
            <td align="center"><strong>Fecha Terminado</strong></td>

            <td align="center"><strong>Id Regional</strong></td>

            <td align="center"><strong>Nombre del Responsable</strong></td>

            <td align="center"><strong>Cedula del Responsable</strong></td>

            <td align="center"><strong>Centro de Costos</strong></td>

            <td align="center"><strong>Orden de Trabajo</strong></td>

            <td align="center"><strong>Nombre de Contratista</strong></td>

            <td align="center"><strong>Cedula de Contratista</strong></td>

            <td align="center"><strong>Telefono de Contratista</strong></td>

            <td align="center"><strong>Direccion de Contratista</strong></td>

            <td align="center"><strong>Contacto de Contratista</strong></td>

            <td align="center"><strong>Regimen de Contratista</strong></td>

            <td align="center"><strong>Correo de Contratista</strong></td>    
            
            <td align="center"><strong>Poliza de Contratista</strong></td>     
            
            <td align="center"><strong>Banco de Contratista</strong></td>  
              
            <td align="center"><strong>Tipo de Cuenta CT</strong></td>

            <td align="center"><strong>Numero de Cuenta de Contratista</strong></td>

            <td align="center"><strong>Observaciones de Contratista</strong></td> 
            
            
            <td align="center"><strong>Total Bruto</strong></td> 
            <td align="center"><strong>IVA</strong></td> 
            <td align="center"><strong>ICA</strong></td> 
            <td align="center"><strong>Rte. Fuente</strong></td> 
            <td align="center"><strong>Neto</strong></td>  
            
			            
        </tr>

	

<?php	
// formato de fecha
    $letters = array('-');
	$fruit   = array('/');	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):
	
		//OT
		$sql3 = "SELECT nombre
				 FROM `proyectos`
				 WHERE `id` = ".$row['id_ordentrabajo'];
		$result3 = mysql_query($sql3) or die("SQL Error 1: " . mysql_error());
		$row3 = mysql_fetch_array($result3, MYSQL_ASSOC);

		//$giro = explode(',00',$row['giro'])
		$sqlPry = "SELECT *, (SELECT nombre FROM regional WHERE id = ".$row['id_regional'].") AS nombre_regional
				   FROM linea_negocio
				   WHERE id=".$row['id_centroscostos']; 
		$qrPry = mysql_query($sqlPry);
		$rsPry = mysql_fetch_array($qrPry);		
		$centro_costo = $rsPry['codigo'].'-'.$rsPry['nombre'];
		
		$impuesto = unserialize($row['impuesto_os']);	
	  	
		$iva = 0;
		$ica = 0;
		$rtefuente = 0;
		$total = 0;
		$neto = 0;
		if(is_array($impuesto)):
		  $iva = $impuesto[0]['iva'];
		  $ica = $impuesto[0]['ica'];
		  $rtefuente = $impuesto[0]['rtefuente'];	  
		  
		  $total = $impuesto[0]['valor_neto_total'];
		  $neto = $impuesto[0]['totalconimpuesto'];
		endif; 


?>

        <tr>

            <td bgcolor="#CCCCCC"><?=$row['id']?></td>

            <td><?=str_replace($letters, $fruit,$row['fecha_inicio'])?></td>
            
            <td><?=str_replace($letters, $fruit,$row['fecha_terminado'])?></td>

            <td><?=$rsPry['nombre_regional']?></td>

            <td><?=$row['nombre_responsable']?></td>

            <td><?=$row['cedula_responsable']?></td>

            <td><?=$centro_costo?></td>

            <td><?=$row3['nombre']?></td>

            <td><?=$row['nombre_contratista']?></td>

            <td><?=$row['cedula_contratista']?></td>

            <td><?=$row['telefono_contratista']?></td>

            <td><?=$row['direccion_contratista']?></td>

            <td><?=$row['contacto_contratista']?></td>
            
            <td><?=$row['regimen_contratista']?></td>
            
            <td><?=$row['correo_contratista']?></td>
            <td><?=$row['poliza_contratista']?></td>

            <td><?=$row['banco_contratista']?></td>

            <td><?=$row['tipocuenta_contratista']?></td>
            
            <td><?=$row['numcuenta_contratista']?></td>
            
            <td><?=$row['observaciones_contratista']?></td>
            
            <td><?=$total?></td>
            <td><?=$iva?></td>
            <td><?=$ica?></td>
            <td><?=$rtefuente?></td>
            <td><?=$neto?></td>
        </tr>

<?	endwhile;?>

	</table>

    

