<?

include "../conexion.php";

if(!empty($_POST['clear'])):

	//echo 'update limpio';
	$sql_update = " UPDATE `hitos` SET 
						po = null,
						po2 = null,
						po3 = null,
						po4 = null, 
						gr = null,  
						gr2 = null,  
						gr3 = null,  
						gr4 = null,  
						factura = null,  
						factura2 = null,  
						factura3 = null,  
						factura4 = null, 
						fecha_facturado1 = null, 
						fecha_facturado2 = null, 
						fecha_facturado3 = null, 
						fecha_facturado4 = null, 
						valor_facturado = null,
						valor_facturado2 = null,
						valorfacturado3 = null,
						valorfacturado4 = null
					WHERE `fecha_real` BETWEEN '2014-01-01' AND '2015-12-30' AND (fecha_facturado1 LIKE '%2015%' || fecha_facturado2 LIKE '%2015%' || fecha_facturado3 LIKE '%2015%' || fecha_facturado4 LIKE '%2015%')"; 
	$result = mysql_query($sql_update) or die("SQL Error 1: " . mysql_error());
	
	
	//segundo script------------------------------*/
	$query = "SELECT * FROM `hitos` WHERE `fecha_real` BETWEEN '2014-01-01' AND '2015-12-30' AND (
factura >=7976 || factura2 >=7976 || factura3 >=7976 || factura4 >=7976)";	  

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	
	
	while($row = mysql_fetch_assoc($result)):
		
		$cadena  = '';
		
		if(!is_numeric($row['factura']) || $row['factura'] >= 7976):
			$cadena .= 'po = null, 
						gr = null, 
						factura = null, 
						valor_facturado = null, 
						fecha_facturado1 = null,';
		endif;
		
		if(!is_numeric($row['factura2']) || $row['factura2'] >= 7976):
			$cadena .= 'po2 = null, 
						gr2 = null, 
						factura2 = null, 
						valor_facturado2 = null, 
						fecha_facturado2 = null,';
		endif;
		
		if(!is_numeric($row['factura3']) || $row['factura3'] >= 7976):
			$cadena .= 'po3 = null, 
						gr3 = null, 
						factura3 = null, 
						valorfacturado3 = null, 
						fecha_facturado3 = null,';
		endif;
		
		if(!is_numeric($row['factura4']) || $row['factura4'] >= 7976):
			$cadena .= 'po4 = null, 
						gr4 = null, 
						factura4 = null, 
						valorfacturado4 = null, 
						fecha_facturado4 = null,';
		endif;
		
		$cadena = substr($cadena,0, -1);
		echo $query_update2 = "UPDATE hitos SET ".$cadena."  WHERE id = ".$row['id'].";";
		echo '<br/>';
		mysql_query($query_update2) or die("SQL Error 1:  " . mysql_error(). "SQL:$query_update2");
		
		
	endwhile;
	
	/*echo $query_update2;
	$result = mysql_query($query_update2) or die("SQL Error 1: " . mysql_error());*/
	
	exit;
	
endif;

/*$query = "SELECT * FROM `hitos` WHERE `fecha_real` BETWEEN '2014-01-01' AND '2015-12-30'
		  AND (fecha_facturado1 LIKE '%2015%' || fecha_facturado2 LIKE '%2015%' || fecha_facturado3 LIKE '%2015%' || fecha_facturado4 LIKE '%2015%')";*/
		  
$query = "SELECT h.id,h.po,h.po2,h.valor_facturado,h.valor_facturado2
		  FROM `hitos` AS h
		  LEFT JOIN hitos_upload AS hp ON h.id = hp.id_hito
		  WHERE `fecha_real` >= '2015-01-01' ";	  
$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());




?>

<form method="post">
	<input type="hidden" value="true" name="clear">
	<input type="submit" value="Limpiar Valores">
</form>



<table border="1">
	<tr>
    	<td>ID hito</td>
        <td>Fecha</td>
        
        <td>PO1</td>
        <td>PO2</td>
        <td>PO3</td>
        <td>PO4</td>
        
        <td>GR1</td>
        <td>GR2</td>
        <td>GR3</td>
        <td>GR4</td>
        
        <td>#Factura1</td>
        <td>#Factura2</td>
        <td>#Factura3</td>
        <td>#Factura4</td>
        
        <td>fecha_facturado1</td>
        <td>fecha_facturado2</td>
        <td>fecha_facturado3</td>
        <td>fecha_facturado4</td>
        
        <td>valorfacturado1</td>
        <td>valorfacturado2</td>
        <td>valorfacturado3</td>
        <td>valorfacturado4</td>
        
    </tr>
<?php
while($row = mysql_fetch_assoc($result)):
?>

	<tr>
    	<td><?=$row['id']?></td>
        <td><?=$row['fecha_real']?></td>
        
        <td><?=$row['po']?></td>
        <td><?=$row['po2']?></td>
        <td><?=$row['po3']?></td>
        <td><?=$row['po4']?></td>
        
        <td><?=$row['gr']?></td>
        <td><?=$row['gr2']?></td>
        <td><?=$row['gr3']?></td>
        <td><?=$row['gr4']?></td>
        
        <td><?=$row['factura']?></td>
        <td><?=$row['factura2']?></td>
        <td><?=$row['factura3']?></td>
        <td><?=$row['factura4']?></td>
        
        <td><?=$row['fecha_facturado1']?></td>
        <td><?=$row['fecha_facturado2']?></td>
        <td><?=$row['fecha_facturado3']?></td>
        <td><?=$row['fecha_facturado4']?></td>
        
        <td><?=$row['valor_facturado']?></td>
        <td><?=$row['valor_facturado2']?></td>
        <td><?=$row['valorfacturado3']?></td>
        <td><?=$row['valorfacturado4']?></td>
        
    </tr>

<?php
endwhile;
?>

</table>