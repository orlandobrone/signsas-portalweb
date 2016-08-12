<?php

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=Documental_export_".date('d-m-Y').".xls");
	header("Content-Transfer-Encoding: binary ");

	include "../../conexion.php";
	include "../extras/php/basico.php";	 

	$query = "SELECT * FROM documental WHERE 1 ORDER BY id DESC";			  
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
?>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">

        	<td align="center"><strong>ID</strong></td>
            <td align="center"><strong>Fecha Creaci&oacute;n</strong></td>
            <td align="center"><strong>C&oacute;digo</strong></td>
            <td align="center"><strong>Nombre Sitio</strong></td>
            <td align="center"><strong>Actividad</strong></td>
            <td align="center"><strong>Cliente</strong></td>
            <td align="center"><strong>OT Tickets</strong></td>
            <td align="center"><strong>ID hito</strong></td>
            <td align="center"><strong>Nombre Documentado</strong></td>   
            <td align="center"><strong>Estado</strong></td>        
            <td align="center"><strong>Fecha Ejecuci&oacute;n Editable</strong></td> 
            <td align="center"><strong>Detalle Actividad</strong></td>           
        </tr>

<?php	

	$letters = array('-');
	$fruit   = array('/');	
	
	$obj = new TaskCurrent;

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):	
	
		switch($row['estado']):
			case 0:
				$estado = 'Creado';
			break;
			case 1:
				$estado = 'Eliminado';
			break;
			case 2:
				$estado = 'Aprobado';
			break;
		endswitch;
?>
        <tr>
            <td bgcolor="#CCCCCC"><?=$row['id']?></td>
            <td><?=$row['fecha_creacion']?></td>
            <td><?=$row['codigo_sitio']?></td>
            <td><?=$row['nombre_sitio']?></td>
            <td><?=$row['actividad']?></td>
            <td><?=$row['cliente']?></td>
            <td><?=$row['ot_tickets']?></td>
            <td><?=$row['hito_id']?></td>
            <td><?=$row['nombre_documentador']?></td>
            <td><?=$estado?></td>
            <td><?=$row['fecha_ejecucion_editable']?></td>                    
            <td><?=$row['detalle_actividad']?></td>
        </tr>
                    

<?		
	endwhile;
?>

	</table>

    