<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	include '../../phpMailer/class.phpmailer.php';
	include '../../phpMailer/class.smtp.php';


	$sql = sprintf("UPDATE documental SET estado = 2 WHERE id=%d;",
		((int)$_REQUEST['id'])
	);
	if(!mysql_query($sql))
		echo "Error al eliminar el documento:\n$sql";
		
	
	$upload_dir = 'uploads/'.$row['id'].'/';
		
	$query = "SELECT * FROM documental WHERE id = ".(int)$_REQUEST['id'];
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	$rs_per = mysql_fetch_assoc($result);
	
	
	$actividad = explode('-',$rs_per['actividad']);
	$subactividad = $actividad[1];
	$actividad = $actividad[0];
	
	$cuerpo = '
		<p>Se aprobo es documento con los siguiente datos:</p>
		<table>
			<tr>
				<td>Fecha Creado</td>
				<td>'.$rs_per['codigo_sitio'].'</td>
				<td>C&oacute;digo Sitio</td>
				<td>'.$rs_per['codigo_sitio'].'</td>
			</tr>
			<tr>
				<td>Actividad</td>
				<td>'.$actividad.'</td>
				<td>Sub - Actividad</td>
				<td>'.$subactividad.'</td>
			</tr>
			<tr>
				<td>Nombre Sitio</td>
				<td>'.$rs_per['nombre_sitio'].'</td>
				<td>Cliente</td>
				<td>'.$rs_per['cliente'].'</td>
			</tr>
			<tr>
				<td>OT, Tickets</td>
				<td>'.$rs_per['ot_tickets'].'</td>
				<td>ID Hito</td>
				<td>'.$rs_per['hito_id'].'</td>
			</tr>
			<tr>
				<td>Nombre Documentador</td>
				<td>'.$rs_per['nombre_documentador'].'</td>
				<td>Fecha de ejecuci&oacute;n editable</td>
				<td>'.$rs_per['fecha_ejecucion_editable'].'</td>
			</tr>
			
			<tr>
				<td>Detalle Actividad</td>
				<td>'.$rs_per['detalle_actividad'].'</td>
			</tr>
			
			
		</table>
	';
	
	
    /*$query2 = "SELECT * FROM documental_items WHERE documental_id = ".(int)$_REQUEST['id'];
	$result2 = mysql_query($query2);
	 
	$upload_dir = 'http://develoment.operacionsign.com/proyectos/documental/uploads/'.(int)$_REQUEST['id'].'/';
	$valid_extensions = array('jpg','png','jpeg','gif');	

	while ($row = mysql_fetch_array($result2, MYSQL_ASSOC)) {
		
		if(in_array($row['tipo_archivo'],$valid_extensions))
			$file = '<img src="'.$upload_dir.$row['nombre_archivo'].'" height="128"/>';
		else
			$file = 'Descargar';

		$cuerpo .= '<tr>
						<td>'.$row['nombre_archivo'].'</td>
						<td>'.$row['tipo_archivo'].'</td>
						<td><a target="_blank" href="'.$upload_dir.$row['nombre_archivo'].'">'.$file.'</a>
						</td>
					<tr>';
		
	}*/
	
	$query2 = "SELECT l.usuario_id, u.email 
			   FROM  `log_eventos` AS l
			   LEFT JOIN  usuario AS u ON u.id = l.usuario_id
			   WHERE l.`modulo` LIKE 'documental' AND l.estado = 'CREADO' AND l.ref_id = ".(int)$_REQUEST['id'];
	$result2 = mysql_query($query2) or die("SQL Error 1: " . mysql_error());
	$rs_per2 = mysql_fetch_assoc($result2);
	
	
	
	
	$mail = new PHPMailer();
	$mail->Host = "localhost";
	$mail->From = 'noreply@operacionesignsas.com';
	$mail->FromName = 'Administrador Signsas';
	$mail->Subject = 'Informe Aprobado';
	$mail->AddAddress('callcenter@signsas.com');	
	$mail->AddAddress($rs_per2['email']);	
	$mail->Body = $cuerpo;
	$mail->IsHTML(true);
	$mail->CharSet = 'ISO-8859-1';
	if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message sent!";
	}
	
	exit;
?>