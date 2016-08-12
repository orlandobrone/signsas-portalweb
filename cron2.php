<?php
include "conexion.php";
include 'phpMailer/class.phpmailer.php';
include 'phpMailer/class.smtp.php'; 


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
   return $resultado+1;
}



/*$query="SELECT id, nombre,ot_cliente,fecha, id_proyecto
		FROM hitos WHERE ot_cliente is NULL OR UPPER(ot_cliente) = 'PENDIENTE'
		ORDER BY id DESC";
$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

  
while ($reg = mysql_fetch_array($result, MYSQL_ASSOC)):

	if (diferenciaEntreFechas($fechaactual,$reg['fecha'],"DIAS",TRUE)>2) {
		
			$sql4 = "SELECT nombre, id_regional FROM `proyectos` WHERE id = ".$reg['id_proyecto']; 
 			$pai4 = mysql_query($sql4);
			$rs_pai4 = mysql_fetch_assoc($pai4);
			
			$otproyecto = $rs_pai4['nombre'];
			$fechaactual = Date("Y-m-d");			
			
			$sql5 = "SELECT email FROM `usuario` WHERE `id_regional` LIKE '%".$rs_pai4['id_regional']."%'"; 
 			$pai5 = mysql_query($sql5);
			
			while($rs_pai5 = mysql_fetch_assoc($pai5)):
			
				$cuerpo = '	<p>Los siguientes hitos a&uacute;n no cuentan con OT Cliente:</p>
							<table border="1" width="438" align="center" cellpadding="0" cellspacing="0">
							<thead>
								<tr>
									<th>ID</th>
									<th>Nombre</th>
									<th>Fecha</th>
									<th>OT Proyecto</th>
								</tr>
							</thead>
							<tbody>';	
				
				$cuerpo .= "<tr>
								<td>".$reg['id']."</td>
								<td>".$reg['nombre']."</td>
								<td>".$reg['fecha']."</td>
								<td>".$otproyecto."</td>
							</tr>";
							
				$cuerpo .= "</tbody></table>";
			
				$receptor = $rs_pai5['email'];
				$copia = 'katherine.betancourt@signsas.com';
				enviar_mensaje('Hitos sin OT CLIENTE',$cuerpo,$receptor,$copia);
				
			endwhile;
	} 
endwhile;



/*Otro Reporte*/
$query="SELECT id, nombre, fecha_inicio_ejecucion, dias_hito
                          FROM hitos 
						 WHERE estado in ('PENDIENTE','EN EJECUCIÓN') AND fecha_inicio_ejecucion > '2014-06-01'
					  ORDER BY id DESC";
  
$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
  
$i=0;
$cuerpo = '<p>Los siguientes hitos se encuentran vencidos:</p>
			<table border="1" width="438" align="center" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>ID</th>
					<th>Nombre</th>
					<th>Fecha Inicio Ejecuci&oacute;n</th>
					<th>Fecha Debi&oacute; Terminar</th>
					<th>D&iacute;as Vencido</th>
				</tr>
			</thead>
			<tbody>';
$fechaactual = Date("Y-m-d");
  
while ($reg = mysql_fetch_array($result, MYSQL_ASSOC))
{
	echo 'Entra';
	if($reg['id']=='7110'){
		echo '1. '+$reg['dias_hito'].'<br>2. '.$reg['fecha_inicio_ejecucion'];
	}
	if (((int)$reg['dias_hito']<=5&&diferenciaEntreFechas($fechaactual,$reg['fecha_inicio_ejecucion'],"DIAS",TRUE)>(2+(int)$reg['dias_hito'])) || ((int)$reg['dias_hito']>5&&diferenciaEntreFechas($fechaactual,$reg['fecha_inicio_ejecucion'],"DIAS",TRUE)>(5+(int)$reg['dias_hito']))) {
		$i++;
		$dias = (int)$reg['dias_hito']*86400;
		$debioterminar = date("Y-m-d",strtotime($reg['fecha_inicio_ejecucion'])+$dias);
		$cuerpo .= "<tr>
						<td>".$reg['id']."</td>
						<td>".$reg['nombre']."</td>
						<td>".$reg['fecha_inicio_ejecucion']."</td>
						<td>".$debioterminar."</td>
						<td>".diferenciaEntreFechas($fechaactual,$debioterminar,"DIAS",TRUE)."</td>
					</tr>";
	} 
}
$cuerpo .= "</tbody>
			</table>";
$receptor = 'jorge.grajalez@signsas.com';

if($i>0)
	enviar_mensaje('Hitos Vencidos',$cuerpo,$receptor);
	
	
  
function enviar_mensaje($asunto,$cuerpo,$receptor){
	
	/*$mail = new PHPMailer();
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
	$mail->FromName = 'Administrador Signsas';	
	
	$mail->SetFrom('noreplay@signsas.com', 'Notificaci&oacute;n');	
	$mail->AddCC($copia);
	//$mail->AddCC("ivan.conrado@signsas.com", "Ivan Conrado");
	
	$mail->Subject = $asunto;
	$mail->MsgHTML($cuerpo);
	
	//indico destinatario
	$mail->AddAddress($receptor);
	
	if(!$mail->Send()) {
		echo "Error al enviar: " . $mail­>ErrorInfo;
	} 
	
	/*$para      = $receptor;
	$titulo    = $asunto;
	$mensaje   = $cuerpo;
	// Para enviar un correo HTML, debe establecerse la cabecera Content-type
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$cabeceras .= 'Cc: ingsistemas.ordonez@gmail.com'. "\r\n";
	
	//mail($para, $titulo, $mensaje, $cabeceras);

	
	// Enviarlo
	mail('ingsistemas.ordonez@gmail.com', $titulo, $mensaje, $cabeceras);*/
	
	$mail = new PHPMailer();
	$mail->Host = "localhost";
	$mail->From = 'noreply@operacionesignsas.com';
	$mail->FromName = 'Administrador Signsas';
	$mail->Subject = $asunto;
	$mail->AddAddress($receptor);
	//$mail->addCC($copia);
	$mail->AddCC('ricardo.hernandez@signsas.com');
	
	$mail->Body = $cuerpo;
	$mail->IsHTML(true);
	$mail->CharSet = 'ISO-8859-1';
	if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message sent!";
	}

}


//TODOS LOS DIAS EL SISTEMA A LA 00:00 DE LA MADRIGADA DEBE CERRAR TODOS LOS CANDADOS ABIERTOS.
$query = "UPDATE hitos SET ilimitado = 0 WHERE ilimitado = 1";
$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());  
mysql_query('TRUNCATE temp_delete');


//cambia de estado los hitos que fueron cambiado por un  estado
$query = "	UPDATE hitos 
			LEFT JOIN cron_hitos ON cron_hitos.id_hito = hitos.id 
			SET hitos.estado = cron_hitos.estado_hito_last			
			WHERE cron_hitos.estado = 0 AND cron_hitos.estado_hito_new NOT IN('ELIMINADO','CANCELADO','DUPLICADO')";

if(mysql_query($query)){
	$query = "UPDATE cron_hitos SET estado = 1 WHERE estado = 0";
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
}else
	die("SQL Error 1: " . mysql_error());


?> 