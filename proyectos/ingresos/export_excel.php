<?php
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=Ingresos_Hitos_export_".date('d-m-Y').".xls");
	header("Content-Transfer-Encoding: binary ");
	
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	$query = "SELECT * FROM ingresos WHERE estado = 'publish' ORDER BY id DESC";
			  
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	
?>
	<table rules="all" border="1">
    	<tr bgcolor="#CCCCCC">
        	<td align="center"><strong>ID</strong></td>
            <td align="center"><strong>Proyecto</strong></td>
            <td align="center"><strong>Cliente</strong></td>
            <td align="center"><strong>P.O</strong></td>
            <td align="center"><strong>GR</strong></td>
            
            <td align="center"><strong>ID Hito</strong></td> 
            <td align="center"><strong>Nombre Hito</strong></td> 
            <td align="center"><strong>Descripcion Hito</strong></td> 
            <td align="center"><strong>Fecha</strong></td> 
            <td align="center"><strong>Valor</strong></td>           
        </tr>
	
<?php	
    $letters = array('-');
	$fruit   = array('/');	
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):
		
		$resultado = mysql_query(" SELECT nombre FROM proyectos WHERE id =".$row['id_proyecto']) or die(mysql_error());
		$rows = mysql_fetch_assoc($resultado);
		
		$sqlMat = sprintf("SELECT c.id AS idCliente, c.nombre AS nombreCliente
						   FROM proyectos AS p
						   LEFT JOIN cliente AS c
						   ON c.id = p.id_cliente
						   WHERE p.id = ".$row['id_proyecto']);
		$perMat = mysql_query($sqlMat);
		$rows_cliente = mysql_fetch_assoc($perMat);
		
		
		$resultado2 = mysql_query("SELECT no FROM po WHERE id =".$row['id_po']) or die(mysql_error());
		$rows2 = mysql_fetch_assoc($resultado2);
		
		
		
		$sql5 = "SELECT * FROM `items_ingresos` WHERE id_ingresos = ".(int)$row['id']." ORDER BY id DESC";
        $pai5 = mysql_query($sql5); 
		
		while($items = mysql_fetch_assoc($pai5)):
			
			$letters = array(',');
			$fruit   = array('.');	
			
			
			$resultado_hito = mysql_query("SELECT id,nombre 
										   FROM hitos
										   WHERE id =".$items['id_hitos']) or die(mysql_error());
			$rows_hito = mysql_fetch_assoc($resultado_hito);
	
?>
                <tr>
                    <td bgcolor="#CCCCCC"><?=$row['id']?></td>
                    <td><?=$rows['nombre']?></td>
                    <td><?=$rows_cliente['nombreCliente']?></td>
                    <td><?=$rows2['no']?></td>
                    <td><?=$row['gr']?></td>
                    
                    <td><?=$items['id_hitos']?></td>
                    <td><?=$rows_hito['nombre']?></td>
                    <td><?=$items['descripcion_hito']?></td>
                    <td><?=$items['fecha_term_hito']?></td>
                    <td><?=$items['valor']?></td>
                </tr>
<?		
		  	endwhile;
	endwhile;
?>
	</table>
    
