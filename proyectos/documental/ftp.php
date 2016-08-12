<?php

	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	$valid_extensions = array('jpg','png','jpeg','gif','xls','xlsx','pdf','doc','docx','ppt','pptx','dwg'); 
 
	// Primero creamos un ID de conexión a nuestro servidor
	$cid = ftp_connect("190.147.21.82");
	// Luego creamos un login al mismo con nuestro usuario y contraseña
	$resultado = ftp_login($cid, "SIGNSAS","SignsasTic*");
	// Comprobamos que se creo el Id de conexión y se pudo hacer el login
	if ((!$cid) || (!$resultado)) {
		echo "Fallo en la conexión"; die;
	} else {
		echo "FTP conectado.";
	}
	
	ftp_pasv ($cid, true) ;
		
	$dir = $_REQUEST['id'];
	
	// intentar crear el directorio $dir
	if (ftp_mkdir($cid, '/Administrativa/Documental/PLATAFORMA/'.$dir)) {
	 	echo "creado con éxito $dir<br>";
	} else {
	 	echo "Ha habido un problema durante la creación de $dir<br>";
	}	
		
	// Nos cambiamos al directorio, donde queremos subir los archivos, si se van a subir a la raíz
	// esta por demás decir que este paso no es necesario. En mi caso uso un directorio llamado boca
	ftp_chdir($cid, '/Administrativa/Documental/PLATAFORMA/'.$dir);
	echo "Cambiado al directorio necesario<br>";   
	// Tomamos el nombre del archivo a transmitir, pero en lugar de usar $_POST, usamos $_FILES que le indica a PHP
	// Que estamos transmitiendo un archivo, esto es en realidad un matriz, el segundo argumento de la matriz, indica	
	
	foreach ($_FILES['archivo']['name'] as $f => $name):
	
		echo "<br/><br/><strong>Nombre: " . $_FILES['archivo']['name'][$f] . "</strong><br>";
		echo "Tipo: " . $_FILES['archivo']['type'][$f] . "<br>";
		echo "Tamaño: " . ($_FILES["archivo"]["size"][$f] / 1024) . " kB<br>";
		echo "Carpeta temporal: " . $_FILES['archivo']['tmp_name'][$f];
		
		$extencion = explode('.',$_FILES['archivo']['name'][$f]);
	
		if(!in_array(strtolower($extencion[1]),$valid_extensions)):
			echo 'El archivo '.$_FILES['archivo']['name'][$f] .' tiene una extención no permitida.<br/>';
		else:
			echo "<br>subiendo el archivo...<br />";
			// Juntamos la ruta del servidor con el nombre real del archivo
			$ruta = "/Administrativa/Documental/PLATAFORMA/".$dir."/".$_FILES['archivo']['name'][$f];
			// Verificamos si no hemos excedido el tamaño del archivo	
			
			if ($tama > 1000000){
				echo "Excede el tamaño del archivo...<br />";
			} else {
				// perform file upload
				$upload = ftp_put($cid, $ruta ,$_FILES['archivo']['tmp_name'][$f], FTP_ASCII);
				// Verificamos si ya se subio el archivo temporal
				if ($upload){
					// copiamos el archivo temporal, del directorio de temporales de nuestro servidor a la ruta que creamos
					echo "Se subio con exito ";
					
					$sql = sprintf("INSERT INTO `documental_items` (nombre_archivo,documental_id,tipo_archivo) VALUES ('%s', %d, '%s');",
						fn_filtro($_FILES['archivo']['name'][$f]),
						fn_filtro((int)$_REQUEST['id']),
						fn_filtro($extencion[1])
					);
					mysql_query($sql);
				}
				// Sino se pudo subir el temporal
				else {
					echo "no se pudo subir el archivo ";
				}
			}
			echo " Ruta: " . $ruta;
		endif;
	endforeach;
	//cerramos la conexión FTP
	ftp_close($cid);
?>