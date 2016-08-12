<?php

	header("Pragma: public");

	header("Expires: 0"); 

	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	header("Content-Type: application/force-download");

	header("Content-Type: application/octet-stream");

	header("Content-Type: application/download");

	header("Content-Disposition: attachment;filename=Costos_export_".date('d-m-Y').".xls");

	header("Content-Transfer-Encoding: binary ");

	

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	$query = "SELECT *

			  FROM prestaciones

			  WHERE 1 ORDER BY id DESC";

			  

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

	

?>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">

        	<td align="center"><strong>ID</strong></td>

            <td align="center"><strong>Concepto</strong></td>

            <td align="center"><strong>Valor</strong></td>

        </tr>

	

<?php	

    $letters = array('.','$',',');

	$fruit   = array('');	

	

	while ($row_item = mysql_fetch_array($result, MYSQL_ASSOC)):
	

?>

                <tr>

                    <td bgcolor="#CCCCCC"><?=$row_item['id']?></td>

                    <td><?=$row_item['concepto']?></td>

                    <td>$<?=$row_item['valor']?></td>

              </tr>

<?                 

	endwhile;

?>

	</table>