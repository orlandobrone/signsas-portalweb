<?php

	header("Pragma: public");

	header("Expires: 0");

	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	header("Content-Type: application/force-download");

	header("Content-Type: application/octet-stream");

	header("Content-Type: application/download");

	header("Content-Disposition: attachment;filename=Ingreso_Mercancia_export_".date('d-m-Y').".xls");

	header("Content-Transfer-Encoding: binary ");

	

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	/*$query = "SELECT *, s.id AS ID, c.nombre AS centro_costo 

			  FROM anticipo AS s 

			  LEFT JOIN centros_costos AS c ON  s.id_centroscostos = c.id 

			  WHERE s.publicado != 'draft' ORDER BY s.id DESC";*/

	/*$query = "	SELECT 	im.id AS id, im.cantidad AS cantidad, im.costo AS costo, im.fecha AS fecha,
				 		i.nombre_material AS nombreMaterial
				FROM ingreso_mercancia AS im
				LEFT JOIN inventario AS i ON im.id_material = i.id
				ORDER BY im.id DESC"; */
				
	$query = "SELECT * FROM ingreso_mercancia WHERE parent = 1";

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
?>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">

        	<td align="center"><strong>ID Mercancia</strong></td>
            
            <td align="center"><strong>ID Despacho</strong></td>

            <td align="center"><strong>ID Material</strong></td>
            
            <td align="center"><strong>Material</strong></td>

            <td align="center"><strong>Cantidad</strong></td>

            <td align="center"><strong>Costo</strong></td>
            
            <td align="center"><strong>IVA</strong></td>
            
            <td align="center"><strong>Orden Compra</strong></td>

            <td align="center"><strong>Fecha Ingreso</strong></td>
           
        </tr>

<?php	

    $letters = array('-');
	$fruit   = array('/');	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):
	
		
		$sql2 = "SELECT i.*, m.nombre_material
				FROM ingreso_mercancia AS i
				LEFT JOIN inventario AS m ON i.id_material = m.id
				WHERE i.id_ingreso =".(int)$row['id'];
  		$resultado = mysql_query($sql2) or die(mysql_error());

		while($row2 = mysql_fetch_assoc($resultado)):		
?>

                <tr>
                    <td bgcolor="#CCCCCC"><?=$row['id']?></td>
                    <td><?=$row['id_despacho']?></td>
                    
                    
                    <td><?=$row2['id_material']?></td>
                    <td><?=$row2['nombre_material']?></td>
                    <td><?=$row['cantidad']?></td>
                    <td><?='$'.number_format($row2['costo'])?></td>
                    <td><?=$row2['iva']?></td>
                    <td><?=$row2['orden_compra']?></td>
                    <td><?=$row2['fecha']?></td>
                   
                </tr>

<?		endwhile;	
	endwhile;
?>

	</table>

    

