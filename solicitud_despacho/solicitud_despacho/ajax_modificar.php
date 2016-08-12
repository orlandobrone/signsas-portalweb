<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	/*verificamos si las variables se envian*/

	if(	empty($_POST['fecha_solicitud']) ||

	    empty($_POST['prioridad']) ||

		empty($_POST['id_regional']) ||

		empty($_POST['nombre_responsable']) ||

		empty($_POST['cedula_responsable']) ||

		empty($_POST['id_centrocostos']) ||

		empty($_POST['id_proyecto']) ||

		empty($_POST['id_hito']) ||

		empty($_POST['direccion_entrega']) ||		

		empty($_POST['nombre_recibe']) ||  

		empty($_POST['celular']) || 

		empty($_POST['fecha_entrega']) || 

		empty($_POST['id_despacho'])){

			

		echo "Usted no ha llenado todos los campos";

		exit;

	}

	

	/*modificar el registro*/

	

	/*$fecha_solicitud = explode("/", $_POST['fecha_solicitud']);

	$fecha_solicitud = date('Y-m-d H:i:s', strtotime($fecha_solicitud[2] . "-" . $fecha_solicitud[1] . "-" . $fecha_solicitud[0] . date("H:i:s", time())));

	

	$fecha_despacho = explode("/", $_POST['fecha_despacho']);

	$fecha_despacho = date('Y-m-d H:i:s', strtotime($fecha_despacho[2] . "-" . $fecha_despacho[1] . "-" . $fecha_despacho[0] . date("H:i:s", time())));

	

	$fecha_entrega = explode("/", $_POST['fecha_entrega']);

	$fecha_entrega = date('Y-m-d H:i:s', strtotime($fecha_entrega[2] . "-" . $fecha_entrega[1] . "-" . $fecha_entrega[0] . date("H:i:s", time())));

    */

	$sql = sprintf("UPDATE solicitud_despacho SET

						fecha_solicitud='%s', 

						prioridad='%s', 

						id_regional='%s', 

						nombre_responsable='%s', 

						cedula_responsable='%s', 

						id_centrocostos='%s', 

						id_proyecto='%s', 

						id_hito='%s', 

						direccion_entrega='%s', 

						nombre_recibe='%s',

						descripcion='%s',

						celular='%s', 

						presupuesto='%s',

						fecha_entrega='%s', 

						estado='pendiente',
						
						asunto='%s'

					WHERE id=%d;",

		fn_filtro($_POST['fecha_solicitud']), 

		fn_filtro($_POST['prioridad']),

		fn_filtro($_POST['id_regional']),

		fn_filtro($_POST['nombre_responsable']),

		fn_filtro($_POST['cedula_responsable']),

		fn_filtro($_POST['id_centrocostos']),

		fn_filtro($_POST['id_proyecto']),

		fn_filtro($_POST['id_hito']),		

		fn_filtro($_POST['direccion_entrega']),

		fn_filtro($_POST['nombre_recibe']),

		fn_filtro($_POST['descripcion']),

		fn_filtro($_POST['celular']),

		fn_filtro($_POST['presupuesto']),

		fn_filtro($_POST['fecha_entrega']),
		
		fn_filtro($_POST['asunto']),

		fn_filtro((int)$_POST['id_despacho'])

	);
	

	if(!mysql_query($sql)):

		echo "Error al actualizar la solicitud:\n$sql";

		exit;
	endif;

	

	$sql = sprintf("select * from solicitud_despacho where id=%d",(int)$_POST['id_despacho']);
	
	
	
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
	
	
	$para = "andrea.rojas@signsas.com,asistente.compras@ts-sas.com"; 
	
	// subject
	
	$titulo = 'Nueva Solicitud de Material #'.(int)$_POST['id_despacho'];
	
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$cabeceras .= 'From: solicitud_despacho@signsas.com'. "\r\n";
	
	//$cabeceras .= 'Cc: ingsistemas.ordonez@gmail.com' . "\r\n";	
	
	
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
	//$mail->AddCC("andrea.rojas@signsas.com.com");
	$mail->AddCC("ingsistemas.ordonez@gmail.com");
	//$mail->AddCC("ivan.conrado@signsas.com.com");
	
	$mail->Subject = $titulo;
	$mail->MsgHTML($mensaje);
	
	//indico destinatario
	$mail->AddAddress($para);
	
	if(!$mail->Send()) {
	echo "Error al enviar: " . $mail­>ErrorInfo;
	} */
	
	
	mail($para, $titulo, $mensaje, $cabeceras);


?>