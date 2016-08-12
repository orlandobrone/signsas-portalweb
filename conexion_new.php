<?
	$bd_host = "localhost";
	$bd_usuario = "operacio_project";
	$bd_password = "Tft36ZBwi2qK"; 
	$bd_base = "operacio_project";
	
	$conexion = mysqli_connect($bd_host, $bd_usuario, $bd_password, $bd_base);
	
	if (!$conexion) {
		echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
		echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
		echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}	
	
	if(session_id() == '') {
		session_start();
	}
		
	require_once('objetos/init.php'); 
	
?>