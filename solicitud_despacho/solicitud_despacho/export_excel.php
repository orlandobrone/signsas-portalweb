<?php

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=Despacho_export_".date('d-m-Y').".xls");
	header("Content-Transfer-Encoding: binary ");

	include "../../conexion.php";
	include "../extras/php/basico.php";
 
	$query = "SELECT *
			  FROM solicitud_despacho	 		
			  WHERE estado != 'draft' ORDER BY id  DESC";


	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	

?>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">

        	<td align="center"><strong>ID</strong></td>

            <td align="center"><strong>Prioridad</strong></td>

            

            <td align="center"><strong>Orden Trabajo</strong></td> 

            <td align="center"><strong>Regi&oacute;n</strong></td>            

            <td align="center"><strong>Centro de Costo</strong></td>
            
            <td align="center"><strong>ID Hito</strong></td>

            <td align="center"><strong>Hito</strong></td>

            

            <td align="center"><strong>Nombre Responsable</strong></td>

            <td align="center"><strong>Cedula Responsable</strong></td>

            <td align="center"><strong>Descripci&oacute;n</strong></td>

            <td align="center"><strong>Direcci&oacute;n Entrega</strong></td>

            <td align="center"><strong>Nombre Recibe</strong></td>

            <td align="center"><strong>PBX/Celular</strong></td>

            <td align="center"><strong>Presupuesto</strong></td>

            

            

            <td align="center"><strong>Fecha Solicitud</strong></td>

            <td align="center"><strong>Fecha Entrega</strong></td>

            <td align="center"><strong>Fecha Registro</strong></td>

        </tr>

	

<?php	

    $letters = array('-');

	$fruit   = array('/');	

	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):

					

					$region = 0;

	

					$sqlPry = "SELECT region FROM regional WHERE id =".$row['id_regional']; 

                    $qrPry = mysql_query($sqlPry);

					$rsPry = mysql_fetch_array($qrPry);

                 	$region = $rsPry['region'];

					

					$sqlPry = "SELECT codigo, nombre FROM linea_negocio WHERE id =".$row['id_centrocostos'];
                    $qrPry = mysql_query($sqlPry);
                    $rsPry = mysql_fetch_array($qrPry);
                    $centrocostos = $rsPry['codigo'].' - '.$rsPry['nombre'];

					

					$sqlPry = "SELECT orden_trabajo FROM orden_trabajo WHERE id_proyecto =".$row['id_proyecto'];

                    	$qrPry = mysql_query($sqlPry);

                        $rsPry = mysql_fetch_array($qrPry);

                    $orden_trabajo = $rsPry['orden_trabajo'];

					

					$sqlPry = "SELECT id,nombre FROM hitos WHERE id =".$row['id_hito'];
                    $qrPry = mysql_query($sqlPry);
                    $rsPry = mysql_fetch_array($qrPry);					
                    $hitos =  $rsPry['nombre'];    
					$idhitos =  $rsPry['id'];

?>

                <tr>

                    <td bgcolor="#CCCCCC"><?=$row['id']?></td>

                    <td><?=$row['prioridad']?></td>

                    <td><?=$orden_trabajo?></td>

                    <td><?=$region?></td>

                    <td><?=$centrocostos?></td>
                    
                    <td><?=$idhitos?></td>

                    <td><?=$hitos?></td>

                    <td><?=$row['nombre_responsable']?></td>

                    <td><?=$row['cedula_responsable']?></td>

                    <td><?=$row['descripcion']?></td>

                    <td><?=$row['direccion_entrega']?></td>

                    <td><?=$row['nombre_recibe']?></td>

                    <td><?=$row['celular']?></td>

                    <td><?=$row['presupuesto']?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_solicitud'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha_entrega'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha'])?></td>

                    

                </tr>

<?		

	endwhile;

?>

	</table>

    

