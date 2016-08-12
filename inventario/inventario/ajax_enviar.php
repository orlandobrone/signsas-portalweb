<?php 

		include "../../conexion.php";

		include "../../ingreso_mercancia/extras/php/basico.php";

		

		/*verificamos si las variables se envian*/

		if(empty($_POST['mensaje'])){

			echo "Usted no a llenado todos los campos"; 

			exit;

		}

		session_start();

				

		$para = "andrea.rojas@singsas.com";

		// subject

		$titulo = 'Solicitud de Material';

		

		// message

		$mensaje = '

		<html>

		<head>

		  <title>Solicitud de Material</title>

		</head>

		<body>

		  <p>Nombre del Solicitante: '.$_SESSION['nombres'].'</p>

		  <p>Mensaje: '.$_POST['mensaje'].'</p>	

		  

		</body>

		</html>';

		

		// Para enviar un correo HTML mail, la cabecera Content-type debe fijarse

		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";

		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		$cabeceras .= 'Cc: fernanda.pino@singsas.com' . "\r\n";

		

		// Cabeceras adicionales

		$cabeceras .= 'To: <replay@sigasas.com>' . "\r\n";
		
		
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";

		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		$cabeceras .= 'From: anticipos@signsas.com'. "\r\n";

		$cabeceras .= 'Cc: rafael.cadena@signsas.com' . "\r\n";		
		
		include '../../phpMailer/class.phpmailer.php';
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
		$mail->Username = "operacionsign@gmail.com";
		$mail->Password = "8wuJgnpn";
		
		
		$mail->SetFrom('noreplay@signsas.com', 'Notificaci&oacute;n');	
		$mail->AddCC("rafael.cadena@signsas.com");
		
		$mail->Subject = $titulo;
		$mail->MsgHTML($mensaje);
		
		//indico destinatario
		$mail->AddAddress($para);
		
		if(!$mail->Send()) {
			echo "Error al enviar: " . $mail­>ErrorInfo;
		}
		

		

		//mail($para, $titulo, $mensaje, $cabeceras);



?>