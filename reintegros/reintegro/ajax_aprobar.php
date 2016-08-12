<?
	include "../../conexion.php";
	include "../../ingreso_mercancia/extras/php/basico.php";
	
	$sql ="UPDATE items_reintegro SET estado = 1 WHERE id_reintegro = " .(int)$_POST['id_reintegro'];
		
	if(!mysql_query($sql)){
		echo "Ocurrio un error\n$sql";
		exit;
	}
	
	$sql4 = "SELECT *, SUM(costo_reintegro) AS total_costo_reintegro 
		     FROM items_reintegro WHERE estado = 1 AND id_reintegro = ".$_POST['id_reintegro'];
    $pai4 = mysql_query($sql4); 
	$rs_items = mysql_fetch_assoc($pai4);
	
    $sql ="UPDATE reintegros SET total_reintegro = ".$rs_items['total_costo_reintegro']." WHERE id = ".$_POST['id_reintegro'];
		
	if(!mysql_query($sql)){
		echo "Ocurrio un error\n$sql";
		exit;
	}
	
	//cargar al inventario los reintegros
	
	$sql = "SELECT 	ir.id_inventario AS id_inventario, 
					ir.cantidad_reintegro, 
					i.cantidad, 
				    (ir.cantidad_reintegro + i.cantidad) AS areintegrar 
			FROM items_reintegro AS ir  
			LEFT JOIN inventario AS i ON ir.id_inventario = i.codigo 
			WHERE ir.estado = 1 AND ir.id_reintegro = ".(int)$_POST['id_reintegro'];
	$pai4 = mysql_query($sql); 

	while( $rs_pai4 = mysql_fetch_assoc($pai4) ):
		$sql ="UPDATE inventario SET cantidad = ".$rs_pai4['areintegrar']." WHERE codigo = ".$rs_pai4['id_inventario'];
		mysql_query($sql);
	endwhile;
	
	
	
	/*$sql = "SELECT *
			FROM reintegros 
			WHERE id = ".(int)$_POST['id_reintegro'];
	$pai4 = mysql_query($sql);
	$rs_reintegro = mysql_fetch_assoc($pai4); 
	
	$mensaje = '
	<html>
		<head>
		  <title>Se ingreso nuevo Anticipo para revisi&oacute;n</title>
		</head>
		<body>
	
		  <p>No. Reintegro: '.$_POST['id_reintegro'].'</p>
	
		  <p>ID Salida Mercancia: '.$rs_reintegro['id_salida_mercancia'].'</p>	
	
		  <p>ID Proyecto: '.$rs_reintegro['id_proyecto'].'</p>	
	
		  <p>ID Hito '.$rs_reintegro['id_hito'].'</p>	  
	
		  <p>Total de Reintegro: '.$rs_reintegro['cedula_responsable'].'</p>
	
		  <p>Fecha de Ingreso: '.$rs_reintegro['fecha_ingreso'].'</p>	
	
		</body>
	</html>';
	
	
	/*$mail = new PHPMailer();
	$mail->Host = "localhost";
	$mail->From = 'noreply@operacionesignsas.com';
	$mail->FromName = 'Administrador Signsas';
	$mail->Subject = 'Nuevo Reintegro';
	$mail->AddAddress('ingsistemas.ordonez@gmail.com');
	//$mail->addCC($copia);
	
	$mail->AddCC('rafael.cadena@signsas.com');
	//$mail->AddCC('noc@signsas.com');
	
	$mail->Body = $mensaje;
	$mail->IsHTML(true);
	$mail->CharSet = 'ISO-8859-1';
	if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message sent!";
	}
	
	
	$titulo = 'Revisado Anticipo #'.$anticipo[1];
	$mensaje = 'Ya fue Aprobado el Anticipo #'.$anticipo[1]; 

	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$cabeceras .= 'From: anticipos@signsas.com'. "\r\n";

	mail($para, $titulo, $mensaje, $cabeceras);*/

	
	exit;

	
	
	/*
	$qrMaterial = mysql_query("SELECT * FROM materiales WHERE id = '" . $_POST['IdMaterial'] . "'");
	$rowsMaterial = mysql_fetch_array($qrMaterial);
	$cantidadMaterial = $rowsMaterial['cantidad'];
	$costoMaterial = $rowsMaterial['costo'];
	
	$qrInventario = mysql_query("SELECT * FROM inventario WHERE id = '" . $_POST['IdMaterial'] . "'");
	$rowsInventario = mysql_fetch_array($qrInventario);
	$cantidad = $rowsInventario['cantidad'] - $cantidadMaterial;
	$qrUpdateInv = mysql_query("UPDATE inventario SET cantidad = '" . $cantidad . "' WHERE id = '" . $_POST['IdMaterial'] . "'");
	
	$fecha_ingreso = date('Y-m-d H:i:s');
	
	$sql = sprintf("INSERT INTO `proyecto_costos` VALUES ('', '%s', '%s', '%s', '%s', '%s', now());",
		fn_filtro($_POST['proyecto']),
		fn_filtro(28),
		fn_filtro(utf8_encode($rowsInventario['nombre_material'])),
		fn_filtro($fecha_ingreso),
		fn_filtro($costoMaterial)
	);

	if(!mysql_query($sql)):
		echo "Error al insertar el costo al proyecto.\n";
	else:
		alertaCostos($_POST['proyecto']);
	endif;
	exit;*/
?>