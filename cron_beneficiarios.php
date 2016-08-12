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


/*Reporte CLINTON*/
$query = "SELECT *
          FROM beneficiarios 
		  WHERE estado = 0 AND clinton = 0 AND fecha_clinton != '0000-00-00'
		  ORDER BY id DESC";
$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

$fechaactual = date("Y-m-d");
$lista = '';
$i = 0;
  
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
	
	$dias = diferenciaEntreFechas($fechaactual,$row['fecha_clinton'],"DIAS",TRUE);
	
	if($dias >= 180):
		//cambio de la opcion clinton
		$query = "	UPDATE beneficiarios 
					SET clinton = 1 			
					WHERE id = ".$row['id'];
		mysql_query($query);
		
	endif;
	
	if($dias == 15):
		$lista .= " <tr>
						<td>".$row['id']."</td>
						<td>".$row['tipo_persona']."</td>
						<td>".$row['nombre']."</td>
						<td>".$row['identificacion']."</td>
						<td>".$row['telefono']."</td>
						<td>".$row['correo']."</td>
					</tr>";
		$i++;
	endif;
	
}

$cuerpo = '<p>Los siguientes beneficiarios esta próximo a vencer la validación de la Lista Clinton:</p>
			<table border="1" width="438" align="center" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>ID</th>
					<th>Tipo Persona</th>
					<th>Nombre</th>
					<th>Identificaci&oacute;n</th>
					<th>Tel&eacute;fono</th>		
					<th>Correo</th>					
				</tr>
			</thead>
			<tbody>';
			
$cuerpo .= $lista;

$cuerpo .= "</tbody>
			</table>";

if($i>0)
	enviar_mensaje('Lista Clinton Vencido',$cuerpo,$receptor);
	
  
function enviar_mensaje($asunto,$cuerpo,$receptor){
	
	$mail = new PHPMailer();
	$mail->Host = "localhost";
	$mail->From = 'noreply@operacionesignsas.com';
	$mail->FromName = 'Administrador Signsas';
	$mail->Subject = $asunto;
	$mail->AddAddress($receptor);
	//$mail->addCC($copia);
	$mail->AddCC('ingsistemas.ordonez@gmail.com,yira.vargas@signsas.com ');
	
	$mail->Body = $cuerpo;
	$mail->IsHTML(true);
	$mail->CharSet = 'ISO-8859-1';
	if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message sent!";
	}

}
