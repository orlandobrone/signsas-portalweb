<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	include "../../festivos.php";
	
	$dias_festivos = new festivos(date("Y"));

/*verificamos si las variables se envian*/

	if(empty($_POST['id'])){

		echo "Debe Ingresar el ID";

		exit;

	}

	

	/*modificar el registro*/
	
	$sqlfgr = "SELECT prioridad FROM anticipo WHERE id = ".$_POST['id'];
	$perfgr = mysql_query($sqlfgr);
	$rs_perfgr = mysql_fetch_assoc($perfgr);
	
	if($rs_per['prioridad'] == 'GIRADO')
		$sql = sprintf("UPDATE `anticipo` SET 
						 estado=1, banco_trans = '%s'	
					   where id=%d;",	
	
			fn_filtro($_POST['nombre_banco']),
			fn_filtro((int)$_POST['id'])
	
		);

	else{
		$fechaaprob = $dias_festivos->proxHabil(date("Y-m-d"));
		$sql = sprintf("UPDATE `anticipo` SET estado=1, banco_trans = '%s', fecha_aprobado = '".$fechaaprob."' WHERE id=%d;",	
			fn_filtro($_POST['nombre_banco']),
			fn_filtro((int)$_POST['id'])
	
		);
		
		$obj = new TaskCurrent();
		$obj->setLogEvento('Anticipo',(int)$_POST['id'],'Aprobado');
	}

	if(!mysql_query($sql)):

		echo "Error al cambiar el estado:\n$sql";

	else:

		$sql=mysql_query(" 	SELECT  a.id_usuario AS idusuario, u.email AS emailuser

										FROM anticipo AS a

										LEFT JOIN usuario AS u ON a.id_usuario = u.id

										WHERE  a.`id` =".(int)$_POST['id'],$con) or

		die("Problemas en la base de datos:".mysql_error());

		$row=mysql_fetch_array($sql);

		

		$para = $row['emailuser'].',asistente.compras@ts-sas.com'; 

		// subject

		$titulo = 'Aprobado Anticipo #'.(int)$_POST['id'];

		$mensaje = 'Ya fue Aprobado el Anticipo #'.(int)$_POST['id'];

		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$cabeceras .= 'From: anticipos@signsas.com'. "\r\n";

		
		/*include '../../phpMailer/class.phpmailer.php';
		include '../../phpMailer/class.smtp.php';
		
		
		$mail = new PHPMailer();
		$mail->IsSMTP();
		//Debo de hacer autenticación SMTP
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";	 
		//indico el servidor de Gmail para SMTP
		$mail->Host = "smtp.gmail.com";
		//indico el puerto que usa Gmail
		$mail->Port = 465;
		//indico un usuario / clave de un usuario de gmail
		$mail->Username = "operacionsign1@gmail.com";
		$mail->Password = "8wuJgnpn";
		
		
		$mail->SetFrom('noreplay@signsas.com', 'Notificaci&oacute;n');	
		$mail->AddCC("andrea.rojas@signsas.com");
		//$mail->AddCC("ingsistemas.ordonez@gmail.com");
		
		$mail->Subject = $titulo; 
		$mail->MsgHTML($mensaje);
		
		//indico destinatario
		$mail->AddAddress($para);
		
		if(!$mail->Send()) {
			echo "Error al enviar: " . $mail­>ErrorInfo;
		} */
		mail($para, $titulo, $mensaje, $cabeceras);

	endif;

	exit;

?>