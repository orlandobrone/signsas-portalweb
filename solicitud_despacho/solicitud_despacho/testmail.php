<?php
		/*include "../../conexion.php";
		include "../extras/php/basico.php";
		
		$sql = sprintf("select * from solicitud_despacho where id= 1471");

		

		if(!$per=mysql_query($sql)):

			echo "Error el preguntar por solicitud :\n$sql";

			exit;

	    endif;

		

		$num_rs_per = mysql_num_rows($per);

		

		if ($num_rs_per==0){

			echo "No existen solicitud con ese ID";

			exit;

		}  

		$rs_per = mysql_fetch_assoc($per);

	

		$mensaje = '

		<img src="http://proyecto.signsas.com/images/logo_sign.png"  style="float:left;"/>

		<h2 style="float:left; margin-left:20px;line-height: 43px;">&nbsp;FORMATO DE SOLICITUD SALIDA MERCANCIA</h2> 

		<div style="clear:both"></div>

		<br />

			<h1>Formato Solicitud de Despacho</h1>

		<table>

				<tbody>

					 <tr>

						<td style="font-weight:bold;">Fecha Solicitud:</td>

						<td>'.$rs_per['fecha_solicitud'].'</td>

				  </tr>

				  <tr>

						<td style="font-weight:bold;">Fecha Entrega:</td>

						<td>'.$rs_per['fecha_entrega'].'</td>

					  

						<td style="font-weight:bold;">Prioridad:</td>

						<td>'.$rs_per['prioridad'].'</td>

					</tr> 

					

					<tr>

						<td colspan="2"><h3>Responsable de la Solicitud</h3></td>

					</tr>';

					

					$sqlPry = "SELECT * FROM regional WHERE id =".$rs_per['id_regional']; 

					$qrPry = mysql_query($sqlPry);

					$rsPry = mysql_fetch_array($qrPry);

					

				   $mensaje .= '<tr>

						<td style="font-weight:bold;">Regional:</td>

						<td>'.$rsPry['region'].'</td>                 

					</tr>

					<tr>        

						<td style="font-weight:bold;">Nombre:</td>

						<td>'.$rs_per['nombre_responsable'].'</td>

						

						<td style="font-weight:bold;">Cedula:</td>

						<td>'.$rs_per['cedula_responsable'].'</td> 

				   </tr>

				   <tr>

					<td></td>

				   </tr>

				   <tr>

					<td></td>

				   </tr>

				   <tr>

					<td></td>

				   </tr>

				   <tr>

					<td></td>

				   </tr>';

		   

		   $sqlPry = "SELECT * FROM centros_costos WHERE id =".$rs_per['id_centrocostos'];

           $qrPry = mysql_query($sqlPry);

           $rsPry = mysql_fetch_array($qrPry);

		          

           $mensaje .= '

		   <tr> 

                <td style="font-weight:bold;">Centro Costo:</td>

                <td>'.$rsPry['sigla'].' / '.$rsPry['nombre'].'</td>            

            	<td style="font-weight:bold;">Orden Trabajo:</td>

                <td>';

				

			$sqlPry = "SELECT * FROM orden_trabajo WHERE id_proyecto =".$rs_per['id_proyecto'];

			$qrPry = mysql_query($sqlPry);

			$rsPry = mysql_fetch_array($qrPry);

			

			

           $mensaje .= $rsPry['orden_trabajo'].'

							</td>

					   </tr> 

					   <tr>

						   <td style="font-weight:bold;">Id Hito:</td>

						   <td>';                    

						$sqlPry = "SELECT * FROM hitos WHERE id =".$rs_per['id_hito'];

						$qrPry = mysql_query($sqlPry);

						$rsPry = mysql_fetch_array($qrPry);

						

						$mensaje .= $rsPry['id'].'      

						   </td> 

					   </tr>
					   <tr>
					   		<td style="font-weight:bold;">Nombre Hito:</td>
							<td>'.$rsPry['nombre'].'</td>
					   </tr>

					</tbody>

				</table>  

				<br />

				<table>

						<tr>

						  <td style="font-weight:bold;">Direcci&oacute;n de entrega</td>

						  <td>'.$rs_per['direccion_entrega'].'</td>

						  <td style="font-weight:bold;">Nombre de quien recibe</td>

						  <td>'.$rs_per['nombre_recibe'].'</td>

						</tr>

						<tr>

						  <td style="font-weight:bold;">Tel&eacute;fono / Celular</td>

						  <td>'.$rs_per['celular'].'</td>

						  <td style="font-weight:bold;">Descripci&oacute;n:</td>

						  <td>'.$rs_per['descripcion'].'</td>

						</tr>   

			   </table>';

   

   		$sql = "SELECT * FROM materiales WHERE id_despacho =".(int)$_POST['id_despacho'];

   		$resultado = mysql_query($sql) or die(mysql_error());

   

   

  		$mensaje .=  ' <h4>Lista Item</h4>   

			   			 <table style="width:100%;table-layout: fixed;word-wrap: break-word;">

						   <tr>

							 <td style="font-weight:bold;">C&oacute;digo:</td>

							 <td style="font-weight:bold;">Material:</td>

							 <td style="font-weight:bold;">Cantidad</td> 

							 <td style="font-weight:bold;">Costo:</td>

							 <td style="font-weight:bold;">Observaci&oacute;n:</td>

							 <td style="font-weight:bold;">Estado:</td>

						   </tr>';

		   

		   

		   			 $total = mysql_num_rows($resultado);

					 if($total > 0):

						   while($row = mysql_fetch_assoc($resultado)):

						   

						    $sql2 = "SELECT nombre_material, codigo FROM inventario WHERE id = ".$row['id_material'];

							$pai2 = mysql_query($sql2); 

							$rs_pai2 = mysql_fetch_assoc($pai2);

						   

						   	switch($row['aprobado']):

									case 0:

									case 3:

										$aprobar = "No Aprobado";

									break;

									case 1:

										$aprobar = "Aprobado";

									break;				

						   	endswitch;

							

						   	$mensaje .= '<tr>

										  <td>'.$rs_pai2['codigo'].'</td> 

										  <td>'.utf8_encode($rs_pai2['nombre_material']).'</td> 

										  <td>'.utf8_encode($row['cantidad']).'</td>

										  <td>$'.$row['costo'].'</td>    

										  <td>'.utf8_encode($row['observacion']).'</td>  

										  <td>'.$aprobar.'</td>        

									   </tr> ';

          

           		 	endwhile; endif;

             

    $mensaje .= '</table>';

	
	*/
	

	$para = "andrea.rojas@signsas.com,asistente.compras@ts-sas.com"; 

	// subject

	$titulo = 'Nueva Solicitud de Material #'.(int)$_POST['id_despacho'];

	

	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";

	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	$cabeceras .= 'From: solicitud_despacho@signsas.com'. "\r\n";

	//$cabeceras .= 'Cc: ingsistemas.ordonez@gmail.com' . "\r\n";	
	
	
	include '../../phpMailer/class.phpmailer.php';
	include '../../phpMailer/class.smtp.php';
	
	$mail = new PHPMailer();
	$mail->Host = "localhost";
	$mail->From = 'noreply@signsas.com';
	$mail->FromName = 'Administrador Signsas';
	$mail->Subject = $titulo;
	$mail->AddAddress('jordonezb@signsas.com');
	$mail->addCC('ingsistemas.ordonez@gmail.com');
	$mail->Body = 'hola test 523232';
	$mail->IsHTML(true);
	$mail->CharSet = 'ISO-8859-1';
	$mail->Send();
	
	
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
	//$mail->AddCC("andrea.rojas@signsas.com");
	//$mail->AddCC("ingsistemas.ordonez@gmail.com");
	//$mail->AddCC("ivan.conrado@signsas.com.com");
	
	$mail->Subject = $titulo;
	$mail->MsgHTML('hola mundo');
	
	//indico destinatario
	//$mail->AddAddress('andrea.rojas@signsas.com');
	$mail->AddAddress("ingsistemas.ordonez@gmail.com");
	
	if(!$mail->Send()) {
		echo "Error al enviar: " . $mail­>ErrorInfo;
	} 
	
?>
