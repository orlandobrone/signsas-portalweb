
<?php

include "../conexion.php";
include "../funciones.php";


$result = mysql_query("SELECT * FROM fechas_hitos WHERE 1 ORDER BY hito_id DESC");

?>

<table border="1">
	<tr>
		<th>ID Hito</th>
        <th>*Fecha 1</th>
        <th>Fecha 1</th>
        
        <th>*Fecha 2</th>
        <th>Fecha 2</th>
        
        <th>*Fecha 3</th>
        <th>Fecha 3</th>
        
        <th>*Fecha 4</th>
        <th>Fecha 4</th>
        
        <th>*Fecha Gran Facturado</th>
        <th>Fecha Gran Facturado</th>
        <th>Cambio?</th>
        <th>Actualizo</th>
<?

while($row = mysql_fetch_assoc($result)):
	
	if(trim($row['fecha_factura1']) != ''):
		$date1 = explode('/',trim($row['fecha_factura1']));
		$date1 = $date1[2].'-'.$date1[1].'-'.$date1['0'];
	else:
		$date1 = '0000-00-00';
	endif;	
	if(trim($row['fecha_factura2']) != ''):
		$date2 = explode('/',trim($row['fecha_factura2']));
		$date2 = $date2[2].'-'.$date2[1].'-'.$date2['0'];
	else:
		$date2 = '0000-00-00';
	endif;	
	if(trim($row['fecha_factura3']) != ''):
		$date3 = explode('/',trim($row['fecha_factura3']));
		$date3 = $date3[2].'-'.$date3[1].'-'.$date3['0'];
	else:
		$date3 = '0000-00-00';
	endif;
	if(trim($row['fecha_factura4']) != ''):
		$date4 = explode('/',trim($row['fecha_factura4']));
		$date4 = $date4[2].'-'.$date4[1].'-'.$date4['0'];
	else:
		$date4 = '0000-00-00';
	endif;
	if(trim($row['fecha_facturado']) != '' && $row['fecha_facturado'] != '0000-00-00'):
		$dateF = explode('/',trim($row['fecha_facturado']));
		$dateF = $dateF[2].'-'.$dateF[1].'-'.$dateF['0'];
	else:
		$dateF = '0000-00-00';
	endif;
	
	$sql = "SELECT COUNT(*) AS total FROM hitos WHERE (
														fecha_facturado1 != '".$date1."' OR
														fecha_facturado2 != '".$date2."' OR
														fecha_facturado3 != '".$date3."' OR
														fecha_facturado4 != '".$date4."' OR
														fecha_facturado != '".$dateF."' 														
														) AND id = ".$row['hito_id'];
	
	$result2 = mysql_query($sql);
	$row2 = mysql_fetch_assoc($result2);
	
	if($row2['total'] >= 1):
		$total = 'SI';
		$color = 'bgcolor="#A8ECED"';
		
		/*$sql = "UPDATE hitos SET fecha_facturado1 = '".$date1."', 
								 fecha_facturado2 = '".$date2."',
								 fecha_facturado3 = '".$date3."',
								 fecha_facturado4 = '".$date4."',
								 fecha_facturado = '".$dateF."'
				WHERE `id` = ".(int)$row['hito_id'];
		$result2 = mysql_query($sql);*/ 
	else:
		$total = 'NO';
		$color =  '';
	endif;
	
	$sql = "SELECT fecha_facturado1,fecha_facturado2,fecha_facturado3,fecha_facturado4,fecha_facturado 
			FROM hitos WHERE id = ".$row['hito_id'];
	$result2 = mysql_query($sql);
	$row2 = mysql_fetch_assoc($result2);
	
	echo '<tr '.$color.'>';	
		echo '<td align="center">'.$row['hito_id'].'</td>'; 
		
		echo '<td align="center">'.$date1.'</td>';
		echo '<td align="center">'.$row2['fecha_facturado1'].'</td>'; 
		
		echo '<td align="center">'.$date2.'</td>';
		echo '<td align="center">'.$row2['fecha_facturado2'].'</td>'; 
		
		echo '<td align="center">'.$date3.'</td>';
		echo '<td align="center">'.$row2['fecha_facturado3'].'</td>'; 
		
		echo '<td align="center">'.$date4.'</td>';
		echo '<td align="center">'.$row2['fecha_facturado4'].'</td>'; 
		
		echo '<td align="center">'.$dateF.'</td>';
		echo '<td align="center">'.$row2['fecha_facturado'].'</td>'; 
		
		echo '<td align="center">'.$total.'</td>';
		echo '<td align="center">'.$total.'</td>';
		
	echo '<tr>';
endwhile;

?>
</table>