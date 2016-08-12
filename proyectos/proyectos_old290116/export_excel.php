<?php
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=Anticipo_export_".date('d-m-Y').".xls");
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
            <td align="center"><strong>Cliente</strong></td>
            <td align="center"><strong>Lugar Ejecución</strong></td>
            <td align="center"><strong>Estado</strong></td>
            <td align="center"><strong>Fecha Inicio</strong></td>
            <td align="center"><strong>Fecha Final</strong></td>
            <td align="center"><strong>Fecha Final Real</strong></td>
            <td align="center"><strong>Cotización</strong></td>      
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
		
		$sql3 = "SELECT nombre FROM cotizacion WHERE id = ".$row['id_cotizacion'];
        $pai3 = mysql_query($sql3); 
		$rs_pai3 = mysql_fetch_assoc($pai3);
		
		$sql4 = "SELECT count(*) AS total FROM `orden_trabajo` WHERE id_proyecto = ".$row['id'];
        $pai4 = mysql_query($sql4); 
		$rs_pai4 = mysql_fetch_assoc($pai4);

?>
                <tr>
                    <td bgcolor="#CCCCCC"><?=$row['id']?></td>
                    <td><?=$row['nombre']?></td>                   
                    <td><?=utf8_encode($row['descripcion'])?></td>    
                    <td><?=$rs_pai2['nombre']?></td>    
                    <td><?=$row['lugar_ejecucion']?></td>    
                    <td><?=$estado[$row['estado']]?></td>    
                    <td><?=$row['fecha_inicio']?></td>                 
                    <td><?=$row['fecha_final']?></td>
                    <td><?=$row['fecha_final_real']?></td>
                    <td><?=$rs_pai3['nombre']?></td>
                </tr>
<?		
	endwhile;
?>
	</table>
    
