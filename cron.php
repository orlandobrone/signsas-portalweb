<?php

include "conexion.php";



$registros=mysql_query("SELECT nombre, fecha_final

                          FROM proyectos 

						  WHERE estado = 'E'",$con) or

  die("Problemas en la base de datos:".mysql_error());

  

while ($reg=mysql_fetch_array($registros))

{

  	$fechaactual = Date("Y-m-d");

	$fechaproyecto = $reg['fecha_final'];

	if (diferenciaEntreFechas($fechaproyecto,$fechaactual,"DIAS",TRUE)<4) {

		enviar_mensaje('El proyecto '.$reg['nombre'].' est� a punto de vencerse o ya est� vencido','Favor revisar el proyecto en cuesti�n. Si ya est� ejecutado, no olvide actualizar su estado');

	} 

}



$registros=mysql_query("SELECT t.nombre as tarea, h.nombre as hito, p.nombre as proyecto, t.fecha_final as fecha 

                          FROM proyectos p, hitos h, tareas t 

						  WHERE p.estado = 'E'",$con) or

  die("Problemas en la base de datos:".mysql_error());

  

while ($reg=mysql_fetch_array($registros))

{

	$fechaactual = Date("Y-m-d");

	$fechatarea = $reg['fecha'];

	if (diferenciaEntreFechas($fechatarea,$fechaactual,"DIAS",TRUE)<2) {

		enviar_mensaje('La tarea '.$reg['tarea'].' est� a punto de vencerse o ya est� vencida','Esta tarea pertenece al proyecto '.$reg['fecha_final'].' y corresponde al hito '.$reg['hito'].' Si est� finalizada o queda como pendiente, no olvide actualizar su estado.');

	} 

}



$registros=mysql_query("SELECT nombre, fecha_final

                          FROM proyectos 

						  WHERE estado = 'P'",$con) or

  die("Problemas en la base de datos:".mysql_error());

  

while ($reg=mysql_fetch_array($registros))

{

  	$fechaactual = Date("Y-m-d");

	$fechaproyecto = $reg['fecha_final'];

	if (diferenciaEntreFechas($fechaproyecto,$fechaactual,"DIAS",TRUE)==-30 || diferenciaEntreFechas($fechaproyecto,$fechaactual,"DIAS",TRUE)==-60 || diferenciaEntreFechas($fechaproyecto,$fechaactual,"DIAS",TRUE)==-90) {

		enviar_mensaje('El proyecto '.$reg['nombre'].' a�n no se ha facturado','La fecha de terminaci�n del proyecto se present� hace m�s de 30, 60 � 90 d�as y a�n no se ha cobrado. Si ya se factur�, favor actualizar el estado.');

	} 

}





$registros=mysql_query("SELECT nombre, fecha_final

                          FROM hitos 

						  WHERE 1",$con) or

  die("Problemas en la base de datos:".mysql_error());

  

while ($reg=mysql_fetch_array($registros))

{

  	$fechaactual = Date("Y-m-d");

	$fechaproyecto = $reg['fecha_final'];

	if (diferenciaEntreFechas($fechatarea,$fechaactual,"DIAS",TRUE)<2) {

		enviar_mensaje('El hito '.$reg['nombre'].' est� a punto de vencerse','Esta tarea pertenece al proyecto '.$reg['fecha_final'].'.Si est� finalizada o queda como pendiente, no olvide actualizar su estado.');

	} 

}





mysql_close($con);

  

function enviar_mensaje($asunto,$tipo){

	$codigohtml = '

	<html>

		<head>

			<title>Alerta vencimiento</title>

		</head>

		<body>

			<h3>'.$tipo.'</h3>

		</body>

	</html>

	';

	

	//$email = 'fgomez@ingecall.com';

	$email2 = 'rafael.cadena@signsas.com';

	$email3 = 'isabel.alfaro@signsas.com';

	

	$headers = "MIME-Version: 1.0" . "\r\n";

	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

	$headers .= 'From: <noreply@ingecall.com>' . "\r\n";

	///$headers .= 'Cc: info@ingecall.com' . "\r\n";
	
	include 'phpMailer/class.phpmailer.php';
	include 'phpMailer/class.smtp.php';
	
	
	$mail = new PHPMailer();
	$mail->IsSMTP();
	//Debo de hacer autenticaci�n SMTP
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
	$mail->AddCC($email2);
	$mail->AddCC($email3);
	//$mail->AddCC("ivan.conrado@signsas.com", "Ivan Conrado");
	
	$mail->Subject = $asunto;
	$mail->MsgHTML($codigohtml);
	
	//indico destinatario
	$mail->AddAddress($email);
	
	if(!$mail->Send()) {
		echo "Error al enviar: " . $mail�>ErrorInfo;
	} 

	

	/*if(mail($email,$asunto,$codigohtml,$headers))

		echo 'Correo enviado';

		

	if(mail($email2,$asunto,$codigohtml,$headers))

		echo 'Correo enviado';

	

	if(mail($email3,$asunto,$codigohtml,$headers))

		echo 'Correo enviado';	*/





}



function diferenciaEntreFechas($fecha_principal, $fecha_secundaria, $obtener = 'SEGUNDOS', $redondear = false){

   $f0 = strtotime($fecha_principal);

   $f1 = strtotime($fecha_secundaria);

   if ($f0 < $f1) { $tmp = $f1; $f1 = $f0; $f0 = $tmp; }

   $resultado = ($f0 - $f1);

   switch ($obtener) {

       default: break;

       case "MINUTOS"   :   $resultado = $resultado / 60;   break;

       case "HORAS"     :   $resultado = $resultado / 60 / 60;   break;

       case "DIAS"      :   $resultado = $resultado / 60 / 60 / 24;   break;

       case "SEMANAS"   :   $resultado = $resultado / 60 / 60 / 24 / 7;   break;

   }

   if($redondear) $resultado = round($resultado);

   return $resultado;

}

?>

