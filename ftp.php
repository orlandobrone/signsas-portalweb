<?php
	// Primero creamos un ID de conexión a nuestro servidor
	$cid = ftp_connect("190.147.21.82");
	// Luego creamos un login al mismo con nuestro usuario y contraseña
	$resultado = ftp_login($cid, "SIGNSAS","SignsasTic*");
	// Comprobamos que se creo el Id de conexión y se pudo hacer el login
	if ((!$cid) || (!$resultado)) {
		echo "Fallo en la conexión"; die;
	} else {
		echo "Conectado.";
	}
	
	
	$dir = 1;
	
	// intentar crear el directorio $dir
	if (ftp_mkdir($cid, '/Administrativa/Documental/PLATAFORMA/'.$dir)) {
	 echo "creado con éxito $dir\n";
	} else {
	 echo "Ha habido un problema durante la creación de $dir\n";
	}
	
?>