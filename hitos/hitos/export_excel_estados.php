<?php

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=Hitos_export_".date('d-m-Y').".xls");
	header("Content-Transfer-Encoding: binary ");

	include "../../conexion.php";
	include "../extras/php/basico.php";	 
	
	$fechas = '';
	if(!empty($_GET['fecini']) && !empty($_GET['fecfin']) && $_GET['fecini'] != 'undefined' && $_GET['fecfin'] != 'undefined')
		$fechas = " AND (l.fecha_cambio BETWEEN '".$_GET['fecini']."' AND '".$_GET['fecfin']."')"; 

	$query = "SELECT l.ref_id, l.usuario_id, l.estado, l.fecha_cambio, h.nombre, u.nombres
			  FROM log_eventos AS l 
			  LEFT JOIN hitos AS h ON h.id = l.ref_id
			  INNER JOIN usuario AS u ON u.id = l.usuario_id
			  WHERE l.modulo IN('Hito') AND l.estado != '' ".$fechas." ORDER BY l.ref_id DESC";			  

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

?>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">
        	<td align="center"><strong>ID Hito</strong></td>
            <td align="center"><strong>Nombre Hito</strong></td>
            <td align="center"><strong>Estado</strong></td>
         	<td align="center"><strong>Responsable</strong></td>
            <td align="center"><strong>Fecha Cambio</strong></td>
        </tr>
<?php	

	$letters = array('-');
	$fruit   = array('/');	
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):	
?>
        <tr>
            <td bgcolor="#CCCCCC"><?=$row['ref_id']?></td>
            <td><?=$row['nombre']?></td>
            <td><?=$row['estado']?></td>
            <td><?=$row['nombres']?></td>
            
            <td><?=str_replace($letters, $fruit,$row['fecha_cambio'])?></td>
        </tr>
<?		
	endwhile;
?>

	</table>

    