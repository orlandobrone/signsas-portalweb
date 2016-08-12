<?php
include "conexion.php";
include 'phpMailer/class.phpmailer.php';
include 'phpMailer/class.smtp.php'; 

/*
$_GET['operacion'] 	
1->barrido de la BD
2->envio de correo de alerta de contratitas que se vence el sgss
*/

if($_GET['operacion'] == 1):
	
	/*Reporte SGSS*/
	$query = "SELECT *
			  FROM beneficiarios 
			  WHERE estado = 0 AND sgss = 0 AND fecha_sgss != '0000-00-00' AND tipo_persona = 'contratista'
			  ORDER BY id DESC";
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	
	$fechactual = date("Y-m-01");
	$lista = '';
	$i = 0;
	  
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
		
		$dias = diferenciaEntreFechas($fechactual,$row['fecha_sgss'],"DIAS",TRUE);
		
		if($dias > 14):
			//cambio de la opcion clinton
			$query = "	UPDATE beneficiarios 
						SET sgss = 0		
						WHERE id = ".$row['id'];
			mysql_query($query);
		endif;
	}

endif;

if($_GET['operacion'] == 2):
	/*Reporte SGSS*/
	$query = "SELECT *
			  FROM beneficiarios 
			  WHERE estado = 0 AND sgss = 0 AND fecha_sgss != '0000-00-00' AND tipo_persona = 'contratista'
			  ORDER BY id DESC";
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	
	$fechactual = date("Y-m-01");
	$lista = '';
	$i = 0;
	  
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
		
		$dias = diferenciaEntreFechas($fechactual,$row['fecha_sgss'],"DIAS",TRUE);
		
		if($dias > 15):
			$lista .= " <tr>
							<td>".$row['id']."</td>
							<td>".$row['nombre']."</td>
							<td>".$row['identificacion']."</td>
							<td>".$row['telefono']."</td>
							<td>".$row['correo']."</td>
							<td>".$row['regimen']."</td>
						</tr>";
			$i++;
		endif;
	}
	
	$cuerpo = ' <p>Los siguientes contratistas esta próximo a vencer SGSS:</p>
				<table border="1" width="438" align="center" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th>ID</th>
						<th>Nombre</th>
						<th>Identificaci&oacute;n</th>
						<th>Tel&eacute;fono</th>		
						<th>Correo</th>		
						<th>Regimen</th>			
					</tr>
				</thead>
				<tbody>';
			
	$cuerpo .= $lista;

	$cuerpo .= "</tbody>
				</table>";

	if($i>0)
		enviar_mensaje('Lista SGSS a Vencer',$cuerpo,$receptor);
endif;




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


function enviar_mensaje($asunto,$cuerpo,$receptor){
	
	$mail = new PHPMailer();
	$mail->Host = "localhost";
	$mail->From = 'noreply@operacionesignsas.com';
	$mail->FromName = 'Administrador Signsas';
	$mail->Subject = $asunto;
	$mail->AddAddress($receptor);
	//$mail->addCC($copia);
	$mail->AddCC('ingsistemas.ordonez@gmail.com,yira.vargas@signsas.com');
	
	$mail->Body = $cuerpo;
	$mail->IsHTML(true);
	$mail->CharSet = 'ISO-8859-1';
	if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message sent!";
	}

}
