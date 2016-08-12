<?php

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=Vehiculos_export_".date('d-m-Y').".xls");
	header("Content-Transfer-Encoding: binary ");

	include "../../conexion.php";
	include "../extras/php/basico.php";

	$query = "SELECT * FROM vehiculos WHERE 1 ORDER BY id DESC";
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

	

?>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">

        	<td align="center"><strong>ID</strong></td>

            <td align="center"><strong>Placa</strong></td>

            <td align="center"><strong>Marca</strong></td>

            <td align="center"><strong>Fecha vencimiento SOAT</strong></td>

            <td align="center"><strong>Fecha Revisi&oacute;n TM</strong></td>

            <td align="center"><strong>Fecha &Uacute;ltimo Aceite</strong></td>

            <td align="center"><strong>Regi&oacute;n</strong></td>

            <td align="center"><strong>Valor Hora</strong></td>

            <td align="center"><strong>Estado</strong></td>

        </tr>

	

<?php	

	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):

		$estado = '';
		$editado = '';
		$aprobar = '';
		$eliminar = '';

		switch($row['estado']):

			case 0:
				$estado = "Activo";
			break;
			case 1:
				$estado = "No Activo";
			break;

			case 2:
				$estado = "Mantenimiento";
			break;
			
			case 2:
				$estado = "Eliminado";
			break;

		endswitch;				

?>

                <tr>

                    <td bgcolor="#CCCCCC"><?=$row['id']?></td>

                    <td><?=$row['placa']?></td>

                    <td><?=$row['marca']?></td>

                    <td><?=$row['soat']?></td>

                    <td><?=$row['tm']?></td>

                    <td><?=$row['aceite']?></td>

                    <td><?=$row['region']?></td>

                    <td>$<?=(int)$row['valor_hora']?></td>

                    <td><?=$estado?></td>                    

                </tr>

<?		

		  	

	endwhile;

?>

	</table>

    

