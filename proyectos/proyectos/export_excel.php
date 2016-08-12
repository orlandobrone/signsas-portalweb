<?php

	header("Pragma: public");

	header("Expires: 0");

	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	header("Content-Type: application/force-download");

	header("Content-Type: application/octet-stream");

	header("Content-Type: application/download");

	header("Content-Disposition: attachment;filename=Proyeto_export_".date('d-m-Y').".xls");

	header("Content-Transfer-Encoding: binary ");

	

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	$query = "SELECT *

			  FROM proyectos

			  WHERE 1 ORDER BY id DESC";

			  

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

	

?>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">

        	<td align="center"><strong>ID</strong></td>

            <td align="center"><strong>Nombre</strong></td>

            <td align="center"><strong>Descripción</strong></td>
			
            <td align="center"><strong>Regional</strong></td>
            
            <td align="center"><strong>Cliente</strong></td>
            
            <td align="center"><strong>Linea de Negocio</strong></td>
            
            <td align="center"><strong>Actividad</strong></td>

            <td align="center"><strong>Estado</strong></td>

            <td align="center"><strong>Fecha Inicio</strong></td>

            <td align="center"><strong>Fecha Final</strong></td>

        </tr>

	

<?php	

    $letters = array('-');

	$fruit   = array('/');	

	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):

		$ots = '';

		$estado = array('E'=>'En ejecuci&oacute;n', 'F'=>'Facturado', 'P'=>'Pendiente de Facturaci&oacute;n');

		
		$sql2 = "SELECT nombre FROM cliente WHERE id = ".$row['id_cliente'];
        $pai2 = mysql_query($sql2); 
		$rs_pai2 = mysql_fetch_assoc($pai2);	
		
		$sqlr = "SELECT nombre, (SELECT nombre FROM actividad WHERE id = ".$row['actividad_id'].") AS actividad
				 FROM linea_negocio where id = ".$row['linea_negocio_id'];
        $pair = mysql_query($sqlr); 
		$rs_pair = mysql_fetch_assoc($pair);		

?>

                <tr>

                    <td bgcolor="#CCCCCC"><?=$row['id']?></td>

                    <td><?=$row['nombre']?></td>                   

                    <td><?=utf8_encode($row['descripcion'])?></td>   
                    
                    <td><?=$row['lugar_ejecucion']?></td>    

                    <td><?=$rs_pai2['nombre']?></td>  
                    
                    <td><?=$rs_pair['nombre']?></td>  
                    <td><?=$rs_pair['actividad']?></td> 

                    <td><?=$estado[$row['estado']]?></td>    

                    <td><?=$row['fecha_inicio']?></td>                 

                    <td><?=$row['fecha_final']?></td>

                </tr>

<?		

	endwhile;

?>

	</table>

    

