<?php
	/*header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=Hitos_export_".date('d-m-Y').".xls");
	header("Content-Transfer-Encoding: binary ");*/
	
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	$query = "	SELECT * FROM asignacion WHERE tecnico = 29 					
			  	ORDER BY id DESC";
			  
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	
	
	$sql3 = "SELECT * FROM tecnico WHERE id = 29";
	$pai3 = mysql_query($sql3); 
	$rs_pai3 = mysql_fetch_assoc($pai3);
	
?>
	
    <h3>FUNCIONARIO / TÉCNICO:</h3>
    
    <table rules="all" border="1">
    	<tr>
        	<td align="center"><strong>Nombre</strong></td>
            <td align="center"><?=$rs_pai3['nombre']?></td>
        
        	<td align="center"><strong>Cedula</strong></td>
            <td align="center"><?=$rs_pai3['cedula']?></td>
        </tr>
        
        <tr>
        	<td align="center"><strong>ARP</strong></td>
            <td align="center"><?=$rs_pai3['ARP']?></td>       
        	<td align="center"><strong>EPS</strong></td>
            <td align="center"><?=$rs_pai3['EPS']?></td>
        </tr>
        
        
        <tr>
        	<td align="center"><strong>Celular</strong></td>
            <td align="center"><?=$rs_pai3['celular']?></td>       
        	<td align="center"><strong>Regi&oacute;n</strong></td>
            <td align="center"><?=$rs_pai3['region']?></td>
        </tr>
        
        <tr>
        	<td align="center"><strong>Cargo</strong></td>
            <td align="center"><?=$rs_pai3['cargo']?></td>       
        	<td align="center"><strong>Valor Hora</strong></td>
            <td align="center"><?=$rs_pai3['valor_hora']?></td>
        </tr>
    </table>
    
	<br />
    
	<table rules="all" border="1">
    	<tr bgcolor="#CCCCCC">
        	<td align="center"><strong>ID</strong></td>
            <td align="center"><strong>Hito</strong></td>
            <td align="center"><strong>Fecha Inicio</strong></td>
            <td align="center"><strong>Fecha Final</strong></td>
            <td align="center"><strong>Hora</strong></td>
        </tr>
	
<?php	

	$letters = array('-');
	$fruit   = array('/');	
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):	
		
		$sql2 = "select nombre FROM hitos WHERE id = ".$row['id_hito'];
		$pai2 = mysql_query($sql2); 
		$rs_pai2 = mysql_fetch_assoc($pai2);
		
?>
                <tr>
                    <td bgcolor="#CCCCCC"><?=$row['id']?></td>
                    <td><?=$rs_pai2['nombre']?></td>                    
                    <td><?=str_replace($letters, $fruit,$row['fecha_inicio'])?></td>
                    <td><?=str_replace($letters, $fruit,$row['fecha_final'])?></td>
                    <td><?=$row['hora_inicio']?> - <?=$row['hora_final']?></td>
                </tr>
<?		
	endwhile;
?>
	</table>
    
