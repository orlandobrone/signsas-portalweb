<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	if(empty($_POST['autorizar'])):
		echo json_encode(array('estado'=>false, 'mensage'=>'Debe seleccionar una opcion para el HITO'));
		exit;
	endif;
	
	
	$obj = new TaskCurrent;	
	
	if($_POST['autorizar'] == 1):	
		$sql = sprintf("UPDATE `hitos` 
						SET `autorizado` = 1, estado = 'LIQUIDADO'
						WHERE `id` = %d", 
			(int)$_POST['id']
		);
		$obj->setPitagoraHito('Autorizado',$_POST['id'],0,0);
	else:
	
		if(empty($_POST['observaciones'])):
			echo json_encode(array('estado'=>false, 'mensage'=>'Debe ingresar el porque no autoriza el HITO'));
			exit;
		endif;		
		
		$sql7 = "SELECT p.id_regional AS id_regional 
				 FROM `hitos` AS h
				 LEFT JOIN proyectos AS p ON h.id_proyecto = p.id
				 WHERE h.id = ".$_POST['id'];
        $pai7 = mysql_query($sql7); 
		$rs_pai7 = mysql_fetch_assoc($pai7); 
		
		$emails = $obj->getEmailsUsuarioByRegional($rs_pai7['id_regional']);

		// título
		$título = 'Hito #'.$_POST['id'].' NO autorizado';
		
		// mensaje
		$mensaje = '
		<html>
			<head>
			  <title>Hito #'.$_POST['id'].' NO autorizado</title>
			</head>
			<body>
			  <table>
				<tr>
				  <th>ID</th>
				  <th>Observación</th>
				  <th>Fecha</th>
				</tr>
				<tr>
				  <td>'.$_POST['id'].'</td>
				  <td>'.$_POST['observaciones'].'</td>
				  <td>'.date('d-m-Y').'</td>
				</tr>
				<tr>
				  <td>Sally</td><td>17</td><td>Agosto</td><td>1973</td>
				</tr>
			  </table>
			</body>
		</html>
		';
		
		// Para enviar un correo HTML, debe establecerse la cabecera Content-type
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Cabeceras adicionales
		$cabeceras .= 'From: Hitos <noreplay@operacionsign.com>' . "\r\n";
		
		// Enviarlo
		mail($emails, $título, $mensaje, $cabeceras);
		$obj->setPitagoraHito('NO Autorizado',$_POST['id'],0,0);	
	
		$sql = sprintf("UPDATE `hitos` 
						SET `autorizado` = 2, estado = 'INFORME ENVIADO', observaciones = '%s'
						WHERE `id` = %d", 
			$_POST['observaciones'],
			(int)$_POST['id']			
		);
		
	endif;	

		
	if(!mysql_query($sql))
		echo "Ocurrio un error\n$sql";
		
	
	echo json_encode(array('estado'=>true));	
	
	exit;
?>

