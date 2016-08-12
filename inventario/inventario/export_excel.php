<?php

	header("Pragma: public");

	header("Expires: 0");

	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	header("Content-Type: application/force-download");

	header("Content-Type: application/octet-stream");

	header("Content-Type: application/download");

	header("Content-Disposition: attachment;filename=Inventario_export_".date('d-m-Y').".xls");

	header("Content-Transfer-Encoding: binary ");

	

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	$query = "SELECT *

			  FROM inventario			

			  WHERE 1 ORDER BY id DESC";

			  

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

	

?>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">

        	<td align="center"><strong>ID</strong></td>

            <td align="center"><strong>C&oacute;digo</strong></td>

            <td align="center"><strong>Ubicaci&oacute;n</strong></td>

            <td align="center"><strong>Nombre Material</strong></td>
            
            <td align="center"><strong>L&iacute;neas</strong></td>

            <td align="center"><strong>Descripci&oacute;n</strong></td>

            <td align="center"><strong>Cantidad</strong></td>

            <td align="center"><strong>Costo Unitario</strong></td>

            <td align="center"><strong>Fecha Registro</strong></td>
            
            <td align="center"><strong>Total</strong></td>

        </tr>

	

<?php	

    $letters = array('-');

	$fruit   = array('/');	


	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):


?>

                <tr>

                    <td bgcolor="#CCCCCC"><?=$row['id']?></td>

                    <td><?=$row['codigo']?></td>
                    
                    <td><?=$row['ubicacion']?></td>
                    
                    <td><?=$row['nombre_material']?></td>
                    
                    <td><?=$row['linea']?></td>

                    <td><?=$row['descripcion']?></td>

                    <td><?=$row['cantidad']?></td>

                    <td><?='$'.number_format($row['costo_unidad'])?></td>

                    <td><?=str_replace($letters, $fruit,$row['fecha'])?></td>
					
                    <td><?='$'.number_format($row['total'])?></td>
                </tr>

<?		

	endwhile;

?>

	</table>

    

