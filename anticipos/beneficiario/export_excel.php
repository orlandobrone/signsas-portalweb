<?php

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=Beneficiarios_export_".date('d-m-Y').".xls");
	header("Content-Transfer-Encoding: binary ");

	include "../../conexion.php";
	include "../extras/php/basico.php"; 

	$query = "SELECT * 
			  FROM beneficiarios
			  WHERE 1 ORDER BY id DESC";   

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

?>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">

        	<td align="center"><strong>ID</strong></td>
            <td align="center"><strong>Tipo Persona</strong></td>
            <td align="center"><strong>Entidad</strong></td>
            <td align="center"><strong>No Cuenta</strong></td>
            <td align="center"><strong>Tipo Cuenta</strong></td>
            <td align="center"><strong>Beneficiario</strong></td>
            <td align="center"><strong>Identificacion</strong></td>
            
            <td align="center"><strong>Contacto</strong></td>
            <td align="center"><strong>Telefono/celular</strong></td>
            <td align="center"><strong>Regimen</strong></td>
            <td align="center"><strong>Correo</strong></td>
            <td align="center"><strong>No. Contrato</strong></td>
            <td align="center"><strong>Direcci&oacute;n</strong></td>
            <td align="center"><strong>Fecha creaci&oacute;n</strong></td>
            <td align="center"><strong>Actividad</strong></td>
            <td align="center"><strong>Estado</strong></td>
            
        </tr>

<?php	

    $letters = array('.','$',',');
	$fruit   = array('');	
		
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):
		

?>

        <tr>
        
          <td bgcolor="#CCCCCC"><?=$row['id']?></td>
          <td><?=$row['tipo_persona']?></td>
          <td><?=$row['entidad']?></td>
          <td><?=$row['num_cuenta']?></td>
          <td><?=$row['tipo_cuenta']?></td>
          <td><?=utf8_encode($row['nombre'])?></td>
          <td><?=$row['identificacion']?></td>
          
          <td><?=$row['contacto']?></td>
          <td><?=$row['telefono']?></td>
          <td><?=$row['regimen']?></td>
          <td><?=$row['correo']?></td>
          <td><?=$row['num_contrato']?></td>
          <td><?=$row['direccion']?></td>
          
          <td><?=$row['fecha_creacion']?></td>
          <td><?=$row['actividad']?></td>
          <td><?=($row['estado']==0)?'Activo':'Inactivo'?>
         
        </tr>

<?
	endwhile;
?>
	</table>

    

