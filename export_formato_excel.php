<?php

	/*header("Pragma: public");

	header("Expires: 0");

	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	header("Content-Type: application/force-download");

	header("Content-Type: application/octet-stream");

	header("Content-Type: application/download");

	header("Content-Disposition: attachment;filename=Hitos_export_".date('d-m-Y').".xls");

	header("Content-Transfer-Encoding: binary ");	*/
	
	setlocale(LC_MONETARY, 'en_US');
	include "conexion.php";
	include "anticipos/extras/php/basico.php";	

	$query = "SELECT * FROM proyectos WHERE 1 ORDER BY id DESC LIMIT 50";
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	

?>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">

            <td align="center"><strong>OT</strong></td>

            <td align="center"><strong>Nombre Hito</strong></td>

            <td align="center"><strong>Total Anticipo</strong></td>

            <td align="center"><strong>Combustible</strong></td>

            <td align="center"><strong>Taxis y Buses</strong></td>
            
            <td align="center"><strong>Otros Gastos</strong></td>
            
            <td align="center"><strong>Trasiegos y Mulares</strong></td>

            <td align="center"><strong>Servicio Ayudantes</strong></td>
            
            <td align="center"><strong>TOES</strong></td>
            
        </tr>

<?php	
	$letters = array('-');
	$fruit   = array('/');	
	
	function getTotalAnticipo($idHito){
		
		$sqlT = "SELECT SUM(total_hito) as total FROM `items_anticipo` WHERE `id_hitos` = ".(int)$idHito;
		$paiT = mysql_query($sqlT); 		
		$rows = mysql_fetch_assoc($paiT);	
		
		return $rows['total'];
	}
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):	

		$sqlh = "SELECT * FROM hitos WHERE id_proyecto = ".$row['id'];
		$paih = mysql_query($sqlh); 
		
		while($rowh = mysql_fetch_assoc($paih)):
		
				$total_anticipo = money_format('%(#1n',getTotalAnticipo($rowh['id']));	
	?>
                <tr>

                    <td bgcolor="#CCCCCC"><?=$row['nombre']?></td>
               
                    <td><?=$rowh['nombre']?></td>

                    <td align="right"><?=$total_anticipo?></td>

                    <td><?=$row['descripcion']?></td>


                </tr>

<?		
		endwhile;
	endwhile;

?>

	</table>

    

