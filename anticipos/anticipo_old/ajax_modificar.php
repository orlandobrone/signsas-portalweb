<?

	session_start();

	include "../../conexion.php";

	include "../extras/php/basico.php";
	
	include "../../festivos.php";
	
	$dias_festivos = new festivos(date("Y"));

	

	

/*verificamos si las variables se envian*/

	if($_POST['prioridad'] == 'GIRADO' && empty($_POST['fechaapr'])){
		echo "Si la prioridad es 'GIRADO', debe seleccionar una fecha de aprobación";
		exit;
	}
	
	elseif($_POST['prioridad'] == 'GIRADO' && !$dias_festivos->esHabil($_POST['fechaapr'])){
		echo "La fecha de aprobación debe ser un día hábil";
		exit;
	}

	if(empty($_POST['fecha']) || empty($_POST['prioridad']) 

	|| empty($_POST['nombre_responsable']) 

	|| empty($_POST['cedula_responsable']) 

	|| empty($_POST['banco'])

	|| empty($_POST['tipo_cuenta'])

	|| empty($_POST['num_cuenta'])

	|| empty($_POST['cedula_consignar'])

	|| empty($_POST['beneficiario'])

	|| empty($_POST['centros_costos'])

	|| empty($_POST['id'])

	){

		echo "Usted no a llenado todos los campos";

		exit;

	}

	

	$sql = sprintf("SELECT * FROM anticipo WHERE id=%d AND publicado='publish'",
		(int)$_POST['id']
	);
	$per = mysql_query($sql);
	$exist_anticipo = mysql_num_rows($per);
	

	if($_POST['action'] != 'edit'):		

		if ($exist_anticipo != 0){

			echo "Existen anticipo con ese ID";

			$para = "ingsistemas.ordonez@gmail.com"; 

			// subject
			$mensaje = '

				<ul>

					<li>Fecha:'.$_POST['fecha'].'</li>

					<li>Prioridad:'.$_POST['prioridad'].'</li>

					<li>Responsable:'.$_POST['nombre_responsable'].'</li>

					<li>CC Responsable:'.$_POST['cedula_responsable'].'</li>

					<li>Cedula Consignar:'.$_POST['cedula_consignar'].'</li>

					<li>Centro Costos:'.$_POST['centros_costos'].'</li>

				</ul>

			';			

			$titulo = 'Existe Anticipo #'.(int)$_POST['id'];
			exit;
		}  

	endif;

	$obj = new TaskCurrent();

	/*modificar el registro*/
	
	if($_POST['prioridad'] == 'GIRADO')
		$fecha_aprobacion = $_POST['fechaapr'];
	else
		$fecha_aprobacion = '';

	$estado = '';
	if($_POST['opcionivn'] == 'i' && $_POST['prioridad'] == 'GIRADO'):
		$estado = ' estado = 1, ';
		
		$titulo = 'Aprobado Anticipo #'.(int)$_POST['id'];
		$mensaje = 'Ya fue Aprobado el Anticipo #'.(int)$_POST['id'];
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$cabeceras .= 'From: anticipos@signsas.com'. "\r\n";
		mail($para, $titulo, $mensaje, $cabeceras);

	endif; 
	
	
	if(!empty($_POST['estado_anticipo']) || $_POST['estado_anticipo'] != ''):
		$obj->setLogEvento('Anticipo',(int)$_POST['id'],'CAMBIO DE ESTADO');
		$estado = ' estado = '.(int)$_POST['estado_anticipo'].', ';
	endif;

	$sql = sprintf("UPDATE `anticipo` SET 

					fecha='%s', 

					prioridad='%s', 

					nombre_responsable='%s', 

					cedula_responsable='%s',

					id_centroscostos='%s',

					id_regional='%s',

					v_cotizado='%s',

					banco='%s',

					tipo_cuenta='%s',

					num_cuenta='%s',

					cedula_consignar='%s',

					beneficiario='%s',

					observaciones='%s',

					id_ordentrabajo='%s',

					id_usuario='%s',

					publicado='publish',

					fecha_creacion = now(),
					
					fecha_aprobado = '%s',
					
					".$estado."
					
					tipo_banco = '%s'

				  WHERE id=%d;",

		fn_filtro($_POST['fecha']),

		fn_filtro($_POST['prioridad']),

		fn_filtro($_POST['nombre_responsable']),

		fn_filtro($_POST['cedula_responsable']),

		fn_filtro($_POST['centros_costos']),

		fn_filtro($_POST['regional']),

		fn_filtro($_POST['v_cotizado']),

		fn_filtro($_POST['banco']),

		fn_filtro($_POST['tipo_cuenta']),

		fn_filtro($_POST['num_cuenta']),

		fn_filtro($_POST['cedula_consignar']),

		fn_filtro($_POST['beneficiario']),

		fn_filtro($_POST['observaciones']),

		fn_filtro($_POST['orden_trabajo']),		
		
		fn_filtro($_SESSION['id']),
		
		fn_filtro($fecha_aprobacion),
		
		fn_filtro($_POST['opcionbanco']),

		fn_filtro((int)$_POST['id']) 

	);
	
	

	if(!mysql_query($sql)){

		echo "Error al actualizar el anticipo:\n$sql";

		exit;

	}else{
		
			  $sql3 = "UPDATE `items_anticipo` SET estado = 1  WHERE estado = 2 AND id_anticipo = ".(int)$_POST['id']; 
			  if(!mysql_query($sql3)){
				  echo "Error al actualizar los hitos"; 
				  exit;
			  }
			  
			  //suma de items del anticipo
			  $total_anticipo = number_format($obj->getSumaTotalItemsByAnticipo((int)$_POST['id'])).',00';
			  
			  //SI el anticipo se esta editando
			  if($_POST['action'] == 'edit'){
				  $sql = sprintf("UPDATE `legalizacion` SET valor_fa='%s' WHERE id_anticipo=%d;",					
					  fn_filtro($total_anticipo),					
					  fn_filtro((int)$_POST['id']) 					
				  );
				  if(!mysql_query($sql)){
					  echo "Error al actualizar legalización:\n$sql";
					  exit;
				  }				  
				  exit;
			  }
			  
			  //crear el log de no revisado para anticipo
			  $obj->setLogEvento('Anticipo',(int)$_POST['id'],'NO REVISADO');
			  
			  //ingresa una nueva legalizacion con el id anticipo
			  $sql2 = sprintf("INSERT INTO `legalizacion` (`id`,`responsable`,`fecha`,`id_anticipo`, `valor_fa`, estado) VALUES ('', '%s', '%s', '%s', '%s', 'NO REVISADO');",
				  fn_filtro($_POST['nombre_responsable']),
				  fn_filtro($_POST['fecha']),	
				  fn_filtro($_POST['id']),
				  fn_filtro($total_anticipo)	
			  );


			  if(!mysql_query($sql2)){
				  echo "Error al insertar la nueva legalizacion:\n$sql2"; 
				  exit;
			  }
			  $id_legalizacion = mysql_insert_id();
		      $obj->setLogEvento('Legalizacion',$id_legalizacion,'NO REVISADO');

	  		  exit;

			  /*$sqlMat = sprintf("SELECT nombre FROM proyectos WHERE id = ".$_POST['proyecto']);

			  $perMat = mysql_query($sqlMat);

			  $rs_per_mat = mysql_fetch_assoc($perMat);*/
				   
			  $mensaje = '';
			  //$para = "rafael.cadena@signsas.com,oscar.galindo@signsas.com"; 
			  //subject
			  $titulo = 'Nuevo Anticipo #'.(int)$_POST['id'];
			  /* Cuerpo del Email del anticipo */		
	

			$sql = sprintf("select * from anticipo where id=%d",
				(int)$_POST['id']
			);
			$per = mysql_query($sql);
			$num_rs_per = mysql_num_rows($per);
			if ($num_rs_per==0){
				echo "No existen anticipo con ese ID";
				exit;
			}  
			$rs_per = mysql_fetch_assoc($per);


			$letters = array('.');
			$fruit   = array('');		
			
			/*
			$acpm = 0;
			$valor_transporte = 0;
			$toes = 0;
			$total_acpm = 0;
			$total_transpornte = 0;
			$total_toes = 0;
			$total_anticipo = 0;

			$resultado = mysql_query("SELECT * FROM items_anticipo WHERE estado = 1 AND id_anticipo =".(int)$_POST['id']) or die(mysql_error());

			$total = mysql_num_rows($resultado);

			while ($rows = mysql_fetch_assoc($resultado)):
			

				if($rows['acpm'] != 0):

					$acpm = explode(',00',$rows['acpm']);

					$acpm = str_replace($letters, $fruit, $acpm[0] );

					$total_acpm += $acpm;

				endif;

				

				if($rows['valor_transporte'] != 0):

					$valor_transporte = explode(',00',$rows['valor_transporte']);

					$valor_transporte = str_replace($letters, $fruit, $valor_transporte[0] );

					$total_acpm += $valor_transporte;

				endif;

				

				if($rows['toes'] != 0):

					$toes = explode(',00',$rows['toes']);

					$toes = str_replace($letters, $fruit, $toes[0] );

					$total_anticipo += $toes;

				endif;

			endwhile;

			$giro = 0;

		

			if($rs_per['giro'] != 0){

				$giro = explode(',00',$rs_per['giro']);

				$giro = str_replace($letters, $fruit, $giro[0] );

			}

			

			$total_anticipo = $total_acpm + $total_toes + $total_anticipo + $giro;		

			$total_anticipo = '$'.number_format($total_anticipo).',00';
		*/
		

		$mensaje = '

		<div id="content_form">

		<img src="http://proyecto.signsas.com/images/logo_sign.png"  style="float:left;"/>

		<h2 style="float:left; margin-left:20px;line-height: 43px;">FORMATO DE SOLICITUD DE ANTICIPO</h2> 

		<div style="clear:both"></div>

		<br />

		<table>

				<tbody>

					 <tr>

						<td width="20%" style="font-weight:bold;">ID:</td>

						<td width="20%" style="font-weight:bold;">'.(int)$_POST['id'].'</td>

						<td width="20%" style="font-weight:bold;">Fecha:</td>

						<td width="30%" style="font-weight:bold;">'.$rs_per['fecha'].'</td>

						<td width="20%" style="font-weight:bold;">Prioridad:</td>

						<td width="30%">'.$rs_per['prioridad'].'</td>

					</tr> 

				 </tbody>

			  </table>       

			  <h3>Responsable del Anticipo</h3>

			  <table>      

					<tr>

						 <td style="font-weight:bold;">Regional:</td>

						 <td>';

						 

							$sqlPry = "SELECT * FROM regional WHERE id =".$rs_per['id_regional']; 

							$qrPry = mysql_query($sqlPry);

							$rsPry = mysql_fetch_array($qrPry);

						 

		$mensaje .= $rsPry['region'].'</td>               

					</tr>

					<tr>           

						<td style="font-weight:bold;">Nombre:</td>

						<td>'.$rs_per['nombre_responsable'].'</td>

						

						<td style="font-weight:bold;">Cedula:</td>

						<td>'.$rs_per['cedula_responsable'].'</td>            

					</tr>';

					

					

					$sqlPry = "SELECT * FROM centros_costos WHERE id=".$rs_per['id_centroscostos']; 

					$qrPry = mysql_query($sqlPry);

					$rsPry = mysql_fetch_array($qrPry);

					

					$centro_costo = $rsPry['sigla'].'/'.$rsPry['nombre'];

					

					$sqlPry = "SELECT * FROM orden_trabajo WHERE id_proyecto = ".$rs_per['id_ordentrabajo']; 

					$qrPry = mysql_query($sqlPry);

					$rsPry = mysql_fetch_array($qrPry);

					$orden_trabajo = $rsPry['orden_trabajo'];

					

					$sqlPry = "SELECT * FROM beneficiarios WHERE identificacion='".$rs_per['cedula_consignar']."'"; 

					$qrPry = mysql_query($sqlPry);

					$row_bene = mysql_fetch_array($qrPry);

					

		 $mensaje .= '<tr>             

						<td style="font-weight:bold;">Centro Costo:</td>

						<td>'.$centro_costo.'</td>              

				   

						<td style="font-weight:bold;">Ordenes de Trabajos:</td>

						<td>'.$orden_trabajo.'</td>

						

					</tr>  

					</tbody>  

			</table>  

			

			<table style="width:100%;">

				<tbody>            

					<tr>

						<td colspan="4"><h3>Consignar a:</h3></td>

					</tr>   

					<tr>

						<td style="font-weight:bold;">CEDULA:</td>

						<td>'.$row_bene['identificacion'].'</td>                 

						<td style="font-weight:bold;">BENEFICIARIO:</td>

						<td>'.$row_bene['beneficiario'].'</td>       

					</tr>          

					<tr>

						<td style="font-weight:bold;">BANCO:</td>

						<td>'.$row_bene['entidad'].'</td>

						

						<td style="font-weight:bold;">TIPO CUENTA:</td>

						<td>'.$row_bene['tipo_cuenta'].'</td> 

					</tr> 

					<tr>    

						<td style="font-weight:bold;">N&deg; DE CUENTA:</td>

						<td>'.$row_bene['num_cuenta'].'</td>         

				   

						<td style="font-weight:bold;">OBSERVACIONES:</td>

						<td>'.$rs_per['observaciones'].'</td>       

					</tr>   

				</tbody>

			</table>

			

			<h3>Informaci&oacute;n del Anticipo</h3>

		   

			<table style="width:100%">

				<tbody>          	

					<tr>

					  <td style="font-weight:bold;">Valor del Giro (Aplica para Efecty, etc):</td>

					  <td>'.$rs_per['giro'].'</td> 

					  <td style="font-weight:bold;">Total Anticipo:</td>

					  <td>'.$total_anticipo.'</td>           

					</tr>       

				</tbody>   

		   </table>';

		   

		   $sql = "SELECT *, i.id AS ID FROM items_anticipo AS i
				   LEFT JOIN hitos AS h ON  h.id = i.id_hitos
				   WHERE i.estado = 1 AND i.id_anticipo = ".(int)$_POST['id'];

		   $resultado = mysql_query($sql) or die(mysql_error());

		   

		   

		   $mensaje .='<div class="agregar_item_content">

					   <h4>Lista Item</h4>   

					   <table style="width:100%;table-layout: fixed;word-wrap: break-word;">

							<tbody>

								   <tr>

									 <td style="font-weight:bold;">Item:</td>

									 <td style="font-weight:bold;">Hitos:</td>

									 <td style="font-weight:bold;">Valor ACPM para el suministro:</td> 

									 <td style="font-weight:bold;">Valor Transporte - Trasiego o Mular:</td>

									 <td style="font-weight:bold;">Valor Viaticos - TOES :</td>

								   </tr>';

				   

				   

							 $total = mysql_num_rows($resultado);

							 if($total > 0):

								   while($row = mysql_fetch_assoc($resultado)):

				   

								   $mensaje .= '<tr>

												  <td>'.$row['id'].'</td>

												  <td>'.utf8_encode($row['nombre']).'</td> 

												  <td>$'.$row['acpm'].'</td>

												  <td>$'.$row['valor_transporte'].'</td>    

												  <td>$'.$row['toes'].'</td>        

											   </tr> ';

				  

							endwhile; endif;

					   

			$mensaje .= '</tbody></table></div>';

					 

					

			// message

			/*$mensaje = '

			<html>

			<head>

			  <title>Se ingreso nuevo Anticipo para revisi&oacute;n</title>

			</head>

			<body>

			  <p>No. Anticipo: '.(int)$_POST['id'].'</p>

			  <p>Fecha: '.$_POST['fecha'].'</p>	

			  <p>Prioridad: '.$_POST['prioridad'].'</p>	

			  <p>Nombre Responsable: '.$_POST['nombre_responsable'].'</p>	  

			  <p>Cedula Responsable: '.$_POST['cedula_responsable'].'</p>

			  <p>Total Anticipo: '.$_POST['total_anticipo'].'</p>	

			  <p>Beneficiario: '.$_POST['beneficiario'].'</p>	

			</body>

			</html>';*/

			

			// Para enviar un correo HTML mail, la cabecera Content-type debe fijarse

			$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$cabeceras .= 'From: anticipos@signsas.com'. "\r\n";

			//$cabeceras .= 'Cc: rafael.cadena@signsas.com' . "\r\n";			

			
			
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
			//$mail->AddCC("ivan.conrado@signsas.com", "Ivan Conrado");
			 
			$mail->Subject = $titulo;
			$mail->MsgHTML($mensaje);
			
			//indico destinatario
			$mail->AddAddress($para); 
			
			if(!$mail->Send()) {
				echo "Error al enviar: " . $mail­>ErrorInfo;
			} */
			
			//mail($para, $titulo, $mensaje, $cabeceras);

			exit;



	}

?>